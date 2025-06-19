<?php

namespace App\Http\Repositories\Api;

use App\Http\Contracts\Api\MonthlyTransactionRepositoryInterface;
use App\Models\SalesOrder;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SalesTarget;
use Carbon\Carbon;

/**
 * Class MonthlyTransactionRepository
 *
 * Repository untuk mengelola data transaksi bulanan.
 * Menyediakan fungsi untuk mengambil data penjualan dalam bentuk agregasi bulanan
 * untuk keperluan analisis dan pelaporan.
 *
 * @package App\Http\Repositories\Api
 */
class MonthlyTransactionRepository implements MonthlyTransactionRepositoryInterface
{
    /**
     * Get monthly transactions for the last 3 years with optional filters for customer and sales ID.
     *
     * @param int|null $customer_id
     * @param int|null $sales_id
     * @return array
     */
    public function getMonthlyTransactionsLast3Years($customer_id = null, $sales_id = null)
    {
        $startDate = Carbon::now()->subYears(3)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $query = SalesOrder::with('items')
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }
        if ($sales_id) {
            $query->where('sales_id', $sales_id);
        }

        $monthly = [];
        $query->chunk(500, function ($orders) use (&$monthly) {
            foreach ($orders as $order) {
                $year = (int)$order->created_at->format('Y');
                $month = (int)$order->created_at->format('n');
                $amount = $order->items->sum(function ($item) {
                    return $item->quantity * $item->selling_price;
                });

                if (!isset($monthly[$year])) {
                    $monthly[$year] = [];
                }
                if (!isset($monthly[$year][$month])) {
                    $monthly[$year][$month] = 0;
                }
                $monthly[$year][$month] += $amount;
            }
        });

        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        $formattedData = [];
        foreach ($monthly as $year => $months) {
            $yearData = [
                'name' => $year,
                'data' => []
            ];
            for ($month = 1; $month <= 12; $month++) {
                $yearData['data'][] = [
                    'x' => $monthNames[$month],
                    'y' => isset($months[$month]) ? number_format($months[$month], 2, '.', '') : '0.00'
                ];
            }
            $formattedData[] = $yearData;
        }

        usort($formattedData, function($a, $b) {
            return $a['name'] <=> $b['name'];
        });

        $customerInfo = $customer_id ? Customer::find($customer_id) : null;
        $customerName = $customerInfo ? $customerInfo->name : null;
        $salesName = null;
        if ($sales_id) {
            $sales = Sale::with('user')->find($sales_id);
            $salesName = $sales && $sales->user ? $sales->user->name : null;
        }

        return [
            'customer' => $customerName,
            'sales' => $salesName,
            'items' => $formattedData
        ];
    }

    /**
     * Menghitung ringkasan data transaksi
     *
     * @param array $formattedData Data yang telah diformat
     * @return array Ringkasan data
     */
    private function calculateSummary($formattedData)
    {
        $totalAmount = 0;
        $totalOrders = 0;
        $totalQuantity = 0;
        $monthsWithData = 0;

        foreach ($formattedData as $yearData) {
            foreach ($yearData['data'] as $monthData) {
                $amount = (float) str_replace(',', '', $monthData['y']);
                $totalAmount += $amount;
                $totalOrders += $monthData['orders'] ?? 0;
                $totalQuantity += $monthData['quantity'] ?? 0;

                if ($amount > 0) {
                    $monthsWithData++;
                }
            }
        }

        return [
            'total_amount' => number_format($totalAmount, 2, '.', ''),
            'total_orders' => $totalOrders,
            'total_quantity' => $totalQuantity,
            'months_with_data' => $monthsWithData,
            'average_monthly_amount' => $monthsWithData > 0
                ? number_format($totalAmount / $monthsWithData, 2, '.', '')
                : '0.00'
        ];
    }

    /**
     * Get monthly transaction summary using ORM
     *
     * @param int $year
     * @param int|null $salesId
     * @return array
     */
    public function getMonthlySummary(int $year, ?int $salesId = null): array
    {
        $query = SalesOrder::query()
            ->with('items')
            ->whereYear('created_at', $year);

        if ($salesId) {
            $query->where('sales_id', $salesId);
        }

        $orders = $query->get();

        $grouped = $orders->groupBy(function ($order) {
            return (int)$order->created_at->format('n');
        });

        $result = [];
        foreach ($grouped as $month => $ordersInMonth) {
            $total_orders = $ordersInMonth->count();
            $total_revenue = $ordersInMonth->flatMap->items->sum(function ($item) {
                return $item->quantity * $item->selling_price;
            });
            $result[] = (object)[
                'month' => $month,
                'total_orders' => $total_orders,
                'total_revenue' => $total_revenue ?? 0
            ];
        }
        return $result;
    }

    /**
     * Get monthly revenue data using ORM
     *
     * @param int $year
     * @param int|null $salesId
     * @return array
     */
    public function getMonthlyRevenue(int $year, ?int $salesId = null): array
    {
        $query = SalesOrder::query()
            ->with('items')
            ->whereYear('created_at', $year);

        if ($salesId) {
            $query->where('sales_id', $salesId);
        }

        $orders = $query->get();

        $grouped = $orders->groupBy(function ($order) {
            return (int)$order->created_at->format('n');
        });

        $result = [];
        foreach ($grouped as $month => $ordersInMonth) {
            $revenue = $ordersInMonth->flatMap->items->sum(function ($item) {
                return $item->quantity * $item->selling_price;
            });
            $result[] = (object)[
                'month' => $month,
                'revenue' => $revenue ?? 0
            ];
        }
        return $result;
    }

    /**
     * Get monthly sales order count using ORM
     *
     * @param int $year
     * @param int|null $salesId
     * @return array
     */
    public function getMonthlyOrderCount(int $year, ?int $salesId = null): array
    {
        $query = SalesOrder::query()
            ->whereYear('created_at', $year);

        if ($salesId) {
            $query->where('sales_id', $salesId);
        }

        $orders = $query->get();

        $grouped = $orders->groupBy(function ($order) {
            return (int)$order->created_at->format('n');
        });

        $result = [];
        foreach ($grouped as $month => $ordersInMonth) {
            $result[] = (object)[
                'month' => $month,
                'order_count' => $ordersInMonth->count()
            ];
        }
        return $result;
    }

    /**
     * Get monthly targets data using ORM
     *
     * @param int $year
     * @param int|null $salesId
     * @return array
     */
    public function getMonthlyTargets(int $year, ?int $salesId = null): array
    {
        $query = SalesTarget::query()
            ->whereYear('active_date', $year);

        if ($salesId) {
            $query->where('sales_id', $salesId);
        }

        $targets = $query->get();

        $grouped = $targets->groupBy(function ($target) {
            return (int)date('n', strtotime($target->active_date));
        });

        $result = [];
        foreach ($grouped as $month => $targetsInMonth) {
            $result[] = (object)[
                'month' => $month,
                'total_target' => $targetsInMonth->sum('amount') ?? 0
            ];
        }
        return $result;
    }

    /**
     * Get monthly revenue and income data using ORM
     *
     * @param int $year
     * @param int|null $salesId
     * @return array
     */
    public function getMonthlyRevenueAndIncome(int $year, ?int $salesId = null): array
    {
        $query = SalesOrder::query()
            ->with('items')
            ->whereYear('created_at', $year);

        if ($salesId) {
            $query->where('sales_id', $salesId);
        }

        $orders = $query->get();

        $grouped = $orders->groupBy(function ($order) {
            return (int)$order->created_at->format('n');
        });

        $result = [];
        foreach ($grouped as $month => $ordersInMonth) {
            $total_revenue = $ordersInMonth->flatMap->items->sum(function ($item) {
                return $item->quantity * $item->selling_price;
            });
            $total_income = $ordersInMonth->flatMap->items->sum(function ($item) {
                return $item->quantity * ($item->selling_price - $item->production_price);
            });
            $result[] = (object)[
                'month' => $month,
                'total_revenue' => $total_revenue ?? 0,
                'total_income' => $total_income ?? 0
            ];
        }
        return $result;
    }

    /**
     * Get monthly targets and transactions data
     *
     * @param int $year
     * @param int|null $salesId
     * @return array
     */
    public function getMonthlyTargetsAndTransactions(int $year, $salesId = null): array
    {
        $targets = collect($this->getMonthlyTargets($year, $salesId));
        $revenueIncome = collect($this->getMonthlyRevenueAndIncome($year, $salesId));
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $targetData = [];
        $revenueData = [];
        $incomeData = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthLabel = $months[$month - 1];
            $targetAmount = $targets->firstWhere('month', $month)->total_target ?? 0;
            $targetData[] = [
                'x' => $monthLabel,
                'y' => number_format($targetAmount, 2, '.', '')
            ];
            $monthData = $revenueIncome->firstWhere('month', $month);
            $revenue = $monthData->total_revenue ?? 0;
            $income = $monthData->total_income ?? 0;
            $revenueData[] = [
                'x' => $monthLabel,
                'y' => number_format($revenue, 2, '.', '')
            ];
            $incomeData[] = [
                'x' => $monthLabel,
                'y' => number_format($income, 2, '.', '')
            ];
        }

        $salesName = null;
        if ($salesId) {
            $sales = Sale::with('user')->find($salesId);
            $salesName = $sales && $sales->user ? $sales->user->name : null;
        }

        return [
            'sales' => $salesName,
            'year' => (string) $year,
            'items' => [
                [
                    'name' => 'Target',
                    'data' => $targetData
                ],
                [
                    'name' => 'Revenue',
                    'data' => $revenueData
                ],
                [
                    'name' => 'Income',
                    'data' => $incomeData
                ]
            ]
        ];
    }

    /**
     * Get monthly sales performance for all sales, with optional filters.
     *
     * @param int $month
     * @param int $year
     * @param bool|null $isUnderperform
     * @return array
     */
    public function getMonthlySalesPerformance(int $month, int $year, ?bool $isUnderperform = null): array
    {
        $salesList = Sale::with('user')->get();

        $targets = SalesTarget::whereYear('active_date', $year)
            ->whereMonth('active_date', $month)
            ->get()
            ->groupBy('sales_id');

        $orders = SalesOrder::with(['items'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get()
            ->groupBy('sales_id');

        $items = [];
        foreach ($salesList as $sale) {
            $salesName = $sale->user ? $sale->user->name : null;

            $revenue = 0;
            if (isset($orders[$sale->id])) {
                $revenue = $orders[$sale->id]->flatMap->items->sum(function ($item) {
                    return $item->quantity * $item->selling_price;
                });
            }

            $target = 0;
            if (isset($targets[$sale->id])) {
                $target = $targets[$sale->id]->sum('amount');
            }

            $percentage = $target > 0 ? round(($revenue / $target) * 100, 2) : 0;

            if ($isUnderperform === true && !($revenue < $target)) {
                continue;
            }
            if ($isUnderperform === false && !($revenue >= $target)) {
                continue;
            }

            $items[] = [
                'sales' => $salesName,
                'revenue' => [
                    'amount' => number_format($revenue, 2, '.', ''),
                    'abbreviation' => $this->abbreviateNumber($revenue)
                ],
                'target' => [
                    'amount' => number_format($target, 2, '.', ''),
                    'abbreviation' => $this->abbreviateNumber($target)
                ],
                'percentage' => $target > 0 ? number_format($percentage, 2, '.', '') : null
            ];
        }

        $monthName = \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        return [
            'is_underperform' => $isUnderperform,
            'month' => $monthName,
            'items' => $items
        ];
    }

    /**
     * Format angka menjadi singkatan (contoh: 1.2M, 1.2B)
     */
    private function abbreviateNumber($number)
    {
        if ($number >= 1000000000) {
            return number_format($number / 1000000000, 2, '.', '') . 'B';
        }
        if ($number >= 1000000) {
            return number_format($number / 1000000, 2, '.', '') . 'M';
        }
        if ($number >= 1000) {
            return number_format($number / 1000, 2, '.', '') . 'K';
        }
        return number_format($number, 2, '.', '');
    }
}