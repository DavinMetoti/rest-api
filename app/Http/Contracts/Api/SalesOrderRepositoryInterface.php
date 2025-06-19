<?php

namespace App\Http\Contracts\Api;

interface SalesOrderRepositoryInterface
{
    /**
     * Store sales order beserta items-nya.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data);
}
