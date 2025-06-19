<?php

namespace App\Http\Contracts\Api;

interface CustomerRepositoryInterface
{
    public function store(array $data);
    public function update($id, array $data);
}
