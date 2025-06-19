<?php

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a sales order with items', function () {
    $customer = Customer::factory()->create();
    $sale = Sale::factory()->create();
    $product = Product::factory()->create();

    $payload = [
        'reference_no' => 'SO-20240620-001',
        'sales_id' => $sale->id,
        'customer_id' => $customer->id,
        'items' => [
            [
                'product_id' => $product->id,
                'quantity' => 5,
                'production_price' => 10000,
                'selling_price' => 15000,
            ]
        ]
    ];

    $response = $this->postJson('/api/sales-orders', $payload);

    $response->assertCreated();
    $response->assertJsonFragment(['reference_no' => 'SO-20240620-001']);
    $this->assertDatabaseHas('sales_orders', ['reference_no' => 'SO-20240620-001']);
    $this->assertDatabaseHas('sales_order_items', [
        'product_id' => $product->id,
        'quantity' => 5,
        'selling_price' => 15000,
    ]);
});

it('cannot create sales order with invalid product', function () {
    $customer = Customer::factory()->create();
    $sale = Sale::factory()->create();

    $payload = [
        'reference_no' => 'SO-20240620-002',
        'sales_id' => $sale->id,
        'customer_id' => $customer->id,
        'items' => [
            [
                'product_id' => 999999,
                'quantity' => 5,
                'production_price' => 10000,
                'selling_price' => 15000,
            ]
        ]
    ];

    $response = $this->postJson('/api/sales-orders', $payload);

    $response->assertStatus(422);
});
