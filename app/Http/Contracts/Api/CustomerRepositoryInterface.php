<?php

namespace App\Http\Contracts\Api;

interface CustomerRepositoryInterface
{
    /**
     * Create new data customer.
     *
     * @return mixed
     */
    public function store(array $data);

    /**
     * Update selected data customer.
     *
     * @return mixed
     */
    public function update($id, array $data);
}
