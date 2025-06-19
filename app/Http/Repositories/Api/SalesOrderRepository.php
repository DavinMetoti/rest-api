<?php

namespace App\Http\Repositories\Api;

use App\Http\Contracts\Api\SalesOrderRepositoryInterface;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Illuminate\Support\Facades\DB;

class SalesOrderRepository implements SalesOrderRepositoryInterface
{
    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $orderData = [
                'reference_no' => $data['reference_no'] ?? null,
                'sales_id'     => $data['sales_id'],
                'customer_id'  => $data['customer_id'],
            ];
            $order = SalesOrder::create($orderData);

            foreach ($data['items'] as $item) {
                $order->salesOrderItems()->create([
                    'product_id'       => $item['product_id'],
                    'quantity'         => $item['quantity'],
                    'production_price' => $item['production_price'],
                    'selling_price'    => $item['selling_price'],
                ]);
            }

            return $order->load('salesOrderItems');
        });
    }
}
