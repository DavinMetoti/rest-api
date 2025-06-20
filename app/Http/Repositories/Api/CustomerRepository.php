<?php

namespace App\Http\Repositories\Api;

use App\Http\Contracts\Api\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * Create new data customer.
     *
     * @return mixed
     */
    public function store(array $data)
    {
        if (isset($data['phone']) && !$this->isValidPhoneNumber($data['phone'])) {
            throw new \Exception('Invalid phone number');
        }
        return Customer::create($data);
    }

    /**
     * Update selected data customer.
     *
     * @return mixed
     */
    public function update($id, array $data)
    {
        if (isset($data['phone']) && !$this->isValidPhoneNumber($data['phone'])) {
            throw new \Exception('Invalid phone number');
        }
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        return $customer;
    }

    /**
     * Validate phone number using Abstract API.
     *
     * @param string $phone
     * @return bool
     */
    private function isValidPhoneNumber($phone)
    {
        $apiKey = env('ABSTRACT_API_KEY');
        if (!$apiKey) {
            return true;
        }
        $response = Http::get("https://phonevalidation.abstractapi.com/v1/", [
            'api_key' => $apiKey,
            'phone' => $phone
        ]);
        if (!$response->ok()) {
            return true;
        }
        $data = $response->json();
        return $data['valid'] ?? false;
    }
}

