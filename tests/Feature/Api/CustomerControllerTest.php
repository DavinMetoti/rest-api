<?php

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a customer', function () {
    $payload = [
        'name' => 'PT Test',
        'address' => 'Jl. Test',
        'phone' => '628123456789',
    ];

    $response = $this->postJson('/api/customers', $payload);

    $response->assertCreated();
    $response->assertJsonFragment(['name' => 'PT Test']);
    $this->assertDatabaseHas('customers', ['name' => 'PT Test']);
});

it('cannot create customer with invalid phone', function () {
    $payload = [
        'name' => 'PT Test',
        'address' => 'Jl. Test',
        'phone' => 'invalid-phone',
    ];

    $response = $this->postJson('/api/customers', $payload);

    $response->assertStatus(422);
    $response->assertJsonFragment(['status' => false]);
});

it('can update a customer', function () {
    $customer = Customer::factory()->create();

    $payload = [
        'name' => 'PT Updated',
        'address' => 'Jl. Baru',
        'phone' => '628123456789',
    ];

    $response = $this->putJson("/api/customers/{$customer->id}", $payload);

    $response->assertOk();
    $response->assertJsonFragment(['name' => 'PT Updated']);
    $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'PT Updated']);
});

it('cannot update customer with invalid phone', function () {
    $customer = Customer::factory()->create();

    $payload = [
        'phone' => 'invalid-phone',
    ];

    $response = $this->putJson("/api/customers/{$customer->id}", $payload);

    $response->assertStatus(422);
    $response->assertJsonFragment(['status' => false]);
});
