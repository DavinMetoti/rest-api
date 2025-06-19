<?php

namespace App\Http\Contracts\Api;

interface MonthlyTransactionRepositoryInterface
{
    /**
     * Get all monthly transactions for a specific customer and sales ID.
     *
     * @param int|null $customer_id The ID of the customer.
     * @param int|null $sales_id The ID of the sales order.
     * @return array
     */
    public function getMonthlyTransactionsLast3Years($customer_id = null, $sales_id = null);

    /**
     * Get monthly targets data using ORM.
     *
     * @param int $year
     * @param int|null $salesId
     * @return array
     */
    public function getMonthlyTargets(int $year, ?int $salesId = null): array;

    /**
     * Get monthly revenue and income data using ORM.
     *
     * @param int $year
     * @param int|null $salesId
     * @return array
     */
    public function getMonthlyRevenueAndIncome(int $year, ?int $salesId = null): array;

    /**
     * Gabungan target, revenue, income bulanan, dan nama sales jika ada.
     */
    public function getMonthlyTargetsAndTransactions(int $year, $salesId = null): array;

    /**
     * Get monthly sales performance for all sales, with optional filters.
     *
     * @param int $month
     * @param int $year
     * @param bool|null $isUnderperform
     * @return array
     */
    public function getMonthlySalesPerformance(int $month, int $year, ?bool $isUnderperform = null): array;
}
