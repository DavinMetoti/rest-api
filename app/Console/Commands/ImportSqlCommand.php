<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ImportSqlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sql {action=import} {--file=Database.sql} {--export-file=export.sql} {--chunk-size=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import/Export SQL data with table selection and progress tracking';

    private $successfulStatements = 0;
    private $failedStatements = 0;
    private $startTime;
    private $errors = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'import':
                return $this->importSql();
            case 'export':
                return $this->exportSql();
            case 'list':
                return $this->listTables();
            default:
                $this->error('Invalid action. Use: import, export, or list');
                return 1;
        }
    }

    /**
     * Import SQL from file with progress tracking
     */
    private function importSql()
    {
        $fileName = $this->option('file');
        $filePath = database_path($fileName);
        $chunkSize = (int) $this->option('chunk-size');

        if (!File::exists($filePath)) {
            $this->error("SQL file not found: {$filePath}");
            return 1;
        }

        $this->warn("⚠️  WARNING: This command will run 'php artisan migrate:refresh' which will:");
        $this->warn("   • Drop all tables in the database");
        $this->warn("   • Re-run all migrations from scratch");
        $this->warn("   • ALL EXISTING DATA WILL BE LOST");
        $this->newLine();

        $confirmed = $this->confirm('Are you sure you want to continue? This action cannot be undone.');

        if (!$confirmed) {
            $this->info("✅ Operation cancelled by user.");
            return 0;
        }

        $doubleConfirmed = $this->confirm('This will permanently delete all data. Type "yes" to confirm you understand the risks.');

        if (!$doubleConfirmed) {
            $this->info("✅ Operation cancelled by user.");
            return 0;
        }

        $this->info("🔄 Running migrate:refresh to prepare database...");

        try {
            $exitCode = Artisan::call('migrate:refresh');

            if ($exitCode === 0) {
                $this->info("✅ Database refreshed successfully");
            } else {
                $this->error("❌ Failed to refresh database");
                return 1;
            }
        } catch (\Exception $e) {
            $this->error("❌ Error during migrate:refresh: " . $e->getMessage());
            return 1;
        }

        $this->info("🚀 Starting SQL import from: {$filePath}");

        try {
            $sqlContent = File::get($filePath);
            $statements = $this->parseStatements($sqlContent);

            $this->info("📄 Found " . count($statements) . " SQL statements");

            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            foreach ($statements as $index => $statement) {
                $this->processStatement($statement, $index + 1);
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

        } catch (\Exception $e) {
            $this->error("❌ Critical error during import: " . $e->getMessage());
        }

        $this->displaySummary();

        if ($this->failedStatements > 0) {
            $this->displayFailedStatements();
            return 1;
        }

        return 0;
    }

    /**
     * Execute the import with detailed progress tracking
     */
    private function executeImport(array $statements, int $chunkSize): int
    {
        $totalStatements = count($statements);
        $successCount = 0;
        $errorCount = 0;
        $startTime = microtime(true);

        $this->info("⚙️  Starting SQL import...");
        $this->info("📦 Processing in chunks of {$chunkSize} statements");

        DB::beginTransaction();

        try {
            $mainProgress = $this->output->createProgressBar($totalStatements);
            $mainProgress->setFormat(
                "Importing: %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%\n" .
                "Status: %message%"
            );
            $mainProgress->start();

            $chunks = array_chunk($statements, $chunkSize);

            foreach ($chunks as $chunkIndex => $chunk) {
                $chunkNumber = $chunkIndex + 1;
                $totalChunks = count($chunks);

                $mainProgress->setMessage("Processing chunk {$chunkNumber}/{$totalChunks}");

                foreach ($chunk as $statementIndex => $statement) {
                    if (!empty(trim($statement))) {
                        try {
                            DB::unprepared($statement);
                            $successCount++;

                            $currentStatement = ($chunkIndex * $chunkSize) + $statementIndex + 1;
                            $mainProgress->setMessage(
                                "Chunk {$chunkNumber}/{$totalChunks} - Statement {$currentStatement}/{$totalStatements}"
                            );

                        } catch (\Exception $e) {
                            $errorCount++;
                            $this->logError($statement, $e->getMessage(), $successCount + $errorCount);
                        }
                    }

                    $mainProgress->advance();

                    if (($successCount + $errorCount) % 50 === 0) {
                        gc_collect_cycles();
                    }
                }

                if ($chunkNumber % 10 === 0 || $chunkNumber === $totalChunks) {
                    $this->newLine();
                    $this->info("✅ Completed chunk {$chunkNumber}/{$totalChunks}");
                }
            }

            $mainProgress->setMessage('Finalizing import...');
            $mainProgress->finish();
            $this->newLine(2);

            DB::commit();

            $endTime = microtime(true);
            $duration = round($endTime - $startTime, 2);

            $this->showImportSummary($successCount, $errorCount, $totalStatements, $duration);

            return $errorCount > 0 ? 1 : 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Critical error during import: " . $e->getMessage());
            $this->showImportSummary($successCount, $errorCount, $totalStatements, microtime(true) - $startTime);
            return 1;
        }
    }

    /**
     * Show import summary with statistics
     */
    private function showImportSummary(int $successCount, int $errorCount, int $totalStatements, float $duration): void
    {
        $this->info("📊 Import Summary");
        $this->info("================");
        $this->info("✅ Successful statements: {$successCount}");

        if ($errorCount > 0) {
            $this->warn("⚠️  Failed statements: {$errorCount}");
        }

        $this->info("📈 Total processed: {$totalStatements}");
        $this->info("⏱️  Duration: {$duration} seconds");
        $this->info("🚀 Average speed: " . round($successCount / max($duration, 0.1), 2) . " statements/second");
        $this->info("💾 Memory peak: " . $this->formatBytes(memory_get_peak_usage(true)));

        if ($errorCount === 0) {
            $this->info("🎉 Import completed successfully!");
        } else {
            $this->warn("⚠️  Import completed with {$errorCount} errors. Check the logs above for details.");
        }
    }

    /**
     * Log error with context
     */
    private function logError(string $statement, string $error, int $statementNumber): void
    {
        $this->newLine();
        $this->warn("⚠️  Error in statement #{$statementNumber}:");
        $this->warn("   Error: {$error}");
        $this->warn("   Statement: " . Str::limit($statement, 100));
        $this->warn("   Continuing with next statement...");
    }

    /**
     * Export SQL with table selection
     */
    private function exportSql()
    {
        $tables = $this->getAllTables();

        if (empty($tables)) {
            $this->error('No tables found in database');
            return 1;
        }

        $this->info('Available tables:');
        foreach ($tables as $index => $table) {
            $this->line(($index + 1) . ". {$table}");
        }

        $choice = $this->choice(
            'Select export option:',
            [
                'all' => 'Export all tables',
                'select' => 'Select specific tables',
                'cancel' => 'Cancel'
            ],
            'all'
        );

        if ($choice === 'cancel') {
            $this->info('Export cancelled.');
            return 0;
        }

        $selectedTables = [];

        if ($choice === 'all') {
            $selectedTables = $tables;
        } else {
            $selectedTables = $this->selectTables($tables);
        }

        if (empty($selectedTables)) {
            $this->info('No tables selected. Export cancelled.');
            return 0;
        }

        return $this->performExport($selectedTables);
    }

    /**
     * List all tables in database
     */
    private function listTables()
    {
        $tables = $this->getAllTables();

        $this->info('Tables in database:');
        $tableData = [];

        foreach ($tables as $table) {
            $count = DB::table($table)->count();
            $tableData[] = [$table, number_format($count)];
        }

        $this->table(['Table Name', 'Record Count'], $tableData);

        return 0;
    }

    /**
     * Get all tables from database
     */
    private function getAllTables(): array
    {
        $databaseName = config('database.connections.' . config('database.default') . '.database');
        $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = ?", [$databaseName]);

        return array_map(function($table) {
            if (isset($table->table_name)) {
                return $table->table_name;
            } elseif (isset($table->TABLE_NAME)) {
                return $table->TABLE_NAME;
            } elseif (is_array($table) && isset($table['table_name'])) {
                return $table['table_name'];
            } elseif (is_array($table) && isset($table['TABLE_NAME'])) {
                return $table['TABLE_NAME'];
            }

            $tableArray = (array) $table;
            return reset($tableArray);
        }, $tables);
    }

    /**
     * Select specific tables for export
     */
    private function selectTables(array $tables): array
    {
        $selected = [];

        $this->info('Select tables (enter table numbers separated by commas, or "all" for all tables):');

        foreach ($tables as $index => $table) {
            $this->line(($index + 1) . ". {$table}");
        }

        $input = $this->ask('Enter your selection');

        if (strtolower($input) === 'all') {
            return $tables;
        }

        $indices = array_map('trim', explode(',', $input));

        foreach ($indices as $index) {
            if (is_numeric($index) && isset($tables[$index - 1])) {
                $selected[] = $tables[$index - 1];
            }
        }

        return $selected;
    }

    /**
     * Perform the actual export with progress tracking
     */
    private function performExport(array $tables): int
    {
        $exportFile = $this->option('export-file');
        $exportPath = database_path($exportFile);

        try {
            $this->info("🚀 Starting export to: {$exportPath}");

            $sql = "-- Database Export\n";
            $sql .= "-- Generated on: " . now()->format('Y-m-d H:i:s') . "\n\n";

            $progressBar = $this->output->createProgressBar(count($tables));
            $progressBar->setFormat('Exporting: %current%/%max% [%bar%] %percent:3s%% %message%');
            $progressBar->start();

            foreach ($tables as $table) {
                $progressBar->setMessage("Exporting table: {$table}");
                $sql .= $this->exportTable($table);
                $progressBar->advance();
            }

            $progressBar->setMessage('Writing to file...');
            $progressBar->finish();
            $this->newLine();

            File::put($exportPath, $sql);

            $this->info("✅ Export completed successfully!");
            $this->info("📁 File saved to: {$exportPath}");
            $this->info("📊 Exported " . count($tables) . " tables");
            $this->info("💾 File size: " . $this->formatBytes(File::size($exportPath)));

            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Error during export: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Export single table structure and data
     */
    private function exportTable(string $table): string
    {
        $sql = "\n-- Table: {$table}\n";

        $createTable = DB::select("SHOW CREATE TABLE `{$table}`")[0];
        $sql .= $createTable->{'Create Table'} . ";\n\n";

        $records = DB::table($table)->get();

        if ($records->count() > 0) {
            $sql .= "-- Data for table {$table}\n";

            foreach ($records->chunk(100) as $chunk) {
                $values = [];
                foreach ($chunk as $record) {
                    $recordArray = (array) $record;
                    $escapedValues = array_map(function($value) {
                        if ($value === null) {
                            return 'NULL';
                        }
                        return "'" . addslashes($value) . "'";
                    }, $recordArray);
                    $values[] = '(' . implode(', ', $escapedValues) . ')';
                }

                $columns = implode('`, `', array_keys((array) $records->first()));
                $sql .= "INSERT INTO `{$table}` (`{$columns}`) VALUES\n";
                $sql .= implode(",\n", $values) . ";\n\n";
            }
        }

        return $sql;
    }

    /**
     * Parse SQL file and split into individual statements with progress tracking
     */
    private function parseSqlStatements(string $sql, $progressBar = null): array
    {
        $totalLength = strlen($sql);
        $currentPos = 0;

        if ($progressBar) $progressBar->setProgress(10);
        $sql = preg_replace('/--.*$/m', '', $sql);
        if ($progressBar) $progressBar->setProgress(20);
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
        if ($progressBar) $progressBar->setProgress(30);

        $sql = preg_replace('/^\/\*!\d+.*?\*\/;?\s*$/m', '', $sql);
        if ($progressBar) $progressBar->setProgress(40);
        $sql = preg_replace('/^SET\s+.*?;?\s*$/m', '', $sql);
        if ($progressBar) $progressBar->setProgress(50);

        $statements = [];
        $current = '';
        $inString = false;
        $stringChar = '';
        $sqlLength = strlen($sql);

        if ($progressBar) $progressBar->setProgress(60);

        for ($i = 0; $i < $sqlLength; $i++) {
            $char = $sql[$i];

            if (!$inString && ($char === '"' || $char === "'")) {
                $inString = true;
                $stringChar = $char;
            } elseif ($inString && $char === $stringChar) {
                if ($i > 0 && $sql[$i - 1] !== '\\') {
                    $inString = false;
                }
            }

            $current .= $char;

            if (!$inString && $char === ';' ) {
                $statement = trim($current);
                if (!empty($statement) && $statement !== ';') {
                    $statements[] = $statement;
                }
                $current = '';
            }

            if ($progressBar && $i % intval($sqlLength / 10) === 0) {
                $progress = 60 + (($i / $sqlLength) * 30);
                $progressBar->setProgress(min(90, $progress));
            }
        }

        $statement = trim($current);
        if (!empty($statement) && $statement !== ';') {
            $statements[] = $statement;
        }

        if ($progressBar) $progressBar->setProgress(95);

        $filteredStatements = array_filter($statements, function($statement) {
            $statement = trim($statement);
            return !empty($statement) &&
                   !preg_match('/^(SET|USE|DELIMITER|\s*$)/', $statement);
        });

        if ($progressBar) $progressBar->setProgress(100);

        return array_values($filteredStatements);
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    private function parseStatements($sqlContent)
    {
        $lines = explode("\n", $sqlContent);
        $cleanedLines = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line) ||
                str_starts_with($line, '--') ||
                str_starts_with($line, '/*') ||
                str_starts_with($line, '*/') ||
                str_starts_with($line, '/*!')) {
                continue;
            }

            $cleanedLines[] = $line;
        }

        $sqlContent = implode(' ', $cleanedLines);

        $statements = [];
        $currentStatement = '';
        $inQuotes = false;
        $quoteChar = '';

        for ($i = 0; $i < strlen($sqlContent); $i++) {
            $char = $sqlContent[$i];

            if (($char === '"' || $char === "'") && !$inQuotes) {
                $inQuotes = true;
                $quoteChar = $char;
            } elseif ($char === $quoteChar && $inQuotes) {
                if ($i > 0 && $sqlContent[$i - 1] !== '\\') {
                    $inQuotes = false;
                    $quoteChar = '';
                }
            }

            if ($char === ';' && !$inQuotes) {
                $statement = trim($currentStatement);
                if (!empty($statement)) {
                    $statements[] = $statement;
                }
                $currentStatement = '';
            } else {
                $currentStatement .= $char;
            }
        }

        $lastStatement = trim($currentStatement);
        if (!empty($lastStatement)) {
            $statements[] = $lastStatement;
        }

        return array_filter($statements, function($statement) {
            return !empty(trim($statement));
        });
    }

    private function processStatement($statement, $index)
    {
        try {
            DB::statement($statement);
            $this->successfulStatements++;

            if ($index % 100 === 0) {
                $this->info("✅ Processed {$index} statements...");
            }

        } catch (\Exception $e) {
            $this->failedStatements++;
            $this->errors[] = [
                'statement_number' => $index,
                'statement' => substr($statement, 0, 100) . (strlen($statement) > 100 ? '...' : ''),
                'error' => $e->getMessage()
            ];

            $this->warn("❌ Statement {$index} failed: " . substr($statement, 0, 50) . '...');
        }
    }

    private function displaySummary()
    {
        $executionTime = round(microtime(true) - $this->startTime, 2);

        $this->newLine();
        $this->info("📊 Import Summary:");
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("✅ Successful statements: {$this->successfulStatements}");
        $this->info("❌ Failed statements: {$this->failedStatements}");
        $this->info("⏱️  Execution time: {$executionTime} seconds");

        if ($this->failedStatements === 0) {
            $this->info("🎉 All statements executed successfully!");
        }
    }

    private function displayFailedStatements()
    {
        if (empty($this->errors)) {
            return;
        }

        $this->newLine();
        $this->error("❌ Failed Statements Details:");
        $this->error("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

        foreach ($this->errors as $error) {
            $this->error("Statement #{$error['statement_number']}:");
            $this->line("  SQL: {$error['statement']}");
            $this->line("  Error: {$error['error']}");
            $this->newLine();
        }
    }
}
