<?php

namespace App\Http\Controllers\Api;

use App\Http\Contracts\Api\MonthlyTransactionRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @group Laporan Transaksi Bulanan
 *
 * Endpoint terkait laporan dan analitik transaksi bulanan, target, dan performa sales.
 *
 * Semua endpoint di grup ini digunakan untuk kebutuhan dashboard, analitik, dan pelaporan performa penjualan.
 * Data yang dihasilkan siap digunakan untuk visualisasi grafik bulanan dan analisis tren penjualan.
 */
class MonthlyTransactionController extends Controller
{
    /**
     * Repository untuk mengelola data transaksi bulanan
     *
     * @var MonthlyTransactionRepositoryInterface
     */
    protected $monthlyRepo;

    /**
     * Constructor untuk inisialisasi dependency injection
     *
     * @param MonthlyTransactionRepositoryInterface $monthlyRepo Repository transaksi bulanan
     */
    public function __construct(MonthlyTransactionRepositoryInterface $monthlyRepo) {
        $this->monthlyRepo = $monthlyRepo;
    }

    /**
     * @subgroup Ringkasan Transaksi 3 Tahun Terakhir
     * @subgroupDescription
     * Dapatkan data agregasi transaksi penjualan per bulan untuk 3 tahun terakhir.
     * Bisa difilter berdasarkan customer maupun sales tertentu.
     *
     * @queryParam customer_id integer optional ID customer untuk memfilter data transaksi. Contoh: 1
     * @queryParam sales_id integer optional ID sales untuk memfilter data transaksi. Contoh: 5
     *
     * @response 200 scenario="Sukses - Data dengan filter customer dan sales"
     * {
     *   "customer": { "id": 1, "name": "PT ABC Corporation", "address": "...", "phone": "..." },
     *   "sales": { "id": 5, "sales_name": "John Doe", "phone": "...", "area_name": "..." },
     *   "items": [
     *     { "name": 2024, "data": [ {"x": "Jan", "y": "15000000.00"}, ... ] },
     *     { "name": 2023, "data": [ {"x": "Jan", "y": "12000000.00"}, ... ] }
     *   ],
     *   "summary": { "total_amount": "...", "total_orders": 267, ... }
     * }
     *
     * @response 400 scenario="Parameter Tidak Valid"
     * {
     *   "error": "Parameter customer_id atau sales_id tidak valid",
     *   "message": "ID yang diberikan tidak ditemukan dalam database"
     * }
     *
     * @response 500 scenario="Kesalahan Server"
     * {
     *   "error": "Terjadi kesalahan server",
     *   "message": "Gagal mengambil data transaksi bulanan"
     * }
     */
    public function getMonthlyTransactions(Request $request): JsonResponse
    {
        $customer_id = $request->input('customer_id');
        $sales_id = $request->input('sales_id');

        if ($customer_id && !is_numeric($customer_id)) {
            return response()->json([
                'error' => 'Parameter tidak valid',
                'message' => 'customer_id harus berupa angka'
            ], 400);
        }

        if ($sales_id && !is_numeric($sales_id)) {
            return response()->json([
                'error' => 'Parameter tidak valid',
                'message' => 'sales_id harus berupa angka'
            ], 400);
        }

        try {
            $transactions = $this->monthlyRepo->getMonthlyTransactionsLast3Years($customer_id, $sales_id);
            return response()->json($transactions, 200);
        } catch (\Exception $e) {
            Log::error('MonthlyTransaction Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => 'Gagal mengambil data transaksi bulanan',
                'debug' => $e->getMessage() // Hapus baris ini di production!
            ], 500);
        }
    }

    /**
     * @subgroup Target, Revenue, dan Income Bulanan
     * @subgroupDescription
     * Mendapatkan data target, revenue, dan income bulanan dalam format siap chart.
     * Bisa difilter berdasarkan tahun dan sales tertentu.
     *
     * @queryParam year integer Tahun yang diambil. Default: tahun ini. Contoh: 2025
     * @queryParam sales_id integer optional ID sales untuk filter. Contoh: 1
     *
     * @response 200 scenario="Sukses"
     * {
     *   "sales": null,
     *   "year": "2025",
     *   "items": [
     *     { "name": "Target", "data": [ {"x": "Jan", "y": "18940000000.00"}, ... ] },
     *     { "name": "Revenue", "data": [ {"x": "Jan", "y": "15677673700.00"}, ... ] },
     *     { "name": "Income", "data": [ {"x": "Jan", "y": "2028803700.00"}, ... ] }
     *   ]
     * }
     *
     * @response 500 scenario="Kesalahan Server"
     * {
     *   "error": "Terjadi kesalahan server",
     *   "message": "Gagal mengambil data target dan transaksi bulanan"
     * }
     */
    public function getMonthlyTargetsAndTransactions(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $salesId = $request->get('sales_id') ?? $request->get('sales');

        try {
            $result = $this->monthlyRepo->getMonthlyTargetsAndTransactions($year, $salesId);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            Log::error('MonthlyTargetsAndTransactions Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => 'Gagal mengambil data target dan transaksi bulanan',
                'debug' => $e->getMessage() // Hapus baris ini di production!
            ], 500);
        }
    }

    /**
     * @subgroup Performa Sales Bulanan
     * @subgroupDescription
     * Mendapatkan performa seluruh sales dalam 1 bulan, termasuk revenue, target, dan persentase pencapaian.
     * Bisa difilter berdasarkan bulan, tahun, dan status underperform.
     *
     * @queryParam month integer Bulan (1-12), default: bulan ini. Contoh: 4
     * @queryParam year integer Tahun, default: tahun ini. Contoh: 2025
     * @queryParam isUnderperform boolean Filter sales underperform (true/false), default: null (all)
     *
     * @response 200 scenario="Sukses"
     * {
     *   "is_underperform": null,
     *   "month": "April 2025",
     *   "items": [
     *     {
     *       "sales": "Salimah Handayani",
     *       "revenue": { "amount": "136796400.00", "abbreviation": "136.8M" },
     *       "target": { "amount": "560000000.00", "abbreviation": "560M" },
     *       "percentage": "24.43"
     *     }
     *   ]
     * }
     *
     * @response 500 scenario="Kesalahan Server"
     * {
     *   "error": "Terjadi kesalahan server",
     *   "message": "Gagal mengambil data performa sales bulanan"
     * }
     */
    public function getMonthlySalesPerformance(Request $request)
    {
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));
        $isUnderperform = $request->has('isUnderperform') ? filter_var($request->input('isUnderperform'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null;

        try {
            $result = $this->monthlyRepo->getMonthlySalesPerformance((int)$month, (int)$year, $isUnderperform);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            Log::error('MonthlySalesPerformance Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => 'Gagal mengambil data performa sales bulanan',
                'debug' => $e->getMessage()
            ], 500);
        }
    }
}