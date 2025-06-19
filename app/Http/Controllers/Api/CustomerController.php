<?php

namespace App\Http\Controllers\Api;

use App\Http\Contracts\Api\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    protected $repo;

    public function __construct(CustomerRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @group Customer
     * @subgroup Create
     * @subgroupDescription Tambah data customer baru.
     *
     * @bodyParam name string required Nama customer. Example: PT ABC
     * @bodyParam address string Alamat customer. Example: Jl. Sudirman No. 1
     * @bodyParam phone string Nomor telepon customer. Example: 628123456789
     *
     * @response 201 scenario="Sukses"
     * {
     *   "id": 1,
     *   "name": "PT ABC",
     *   "address": "Jl. Sudirman No. 1",
     *   "phone": "628123456789"
     * }
     * @response 422 scenario="Gagal validasi"
     * {
     *   "status": false,
     *   "message": "Invalid phone number"
     * }
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $customer = $this->repo->store($request->validated());
            return response()->json($customer, 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * @group Customer
     * @subgroup Update
     * @subgroupDescription Update data customer.
     *
     * @urlParam id integer required ID customer yang akan diupdate. Example: 1
     * @bodyParam name string Nama customer. Example: PT DEF
     * @bodyParam address string Alamat customer. Example: Jl. Thamrin No. 2
     * @bodyParam phone string Nomor telepon customer. Example: 628129876543
     *
     * @response 200 scenario="Sukses"
     * {
     *   "id": 1,
     *   "name": "PT DEF",
     *   "address": "Jl. Thamrin No. 2",
     *   "phone": "628129876543"
     * }
     * @response 422 scenario="Gagal validasi"
     * {
     *   "status": false,
     *   "message": "Invalid phone number"
     * }
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        try {
            $customer = $this->repo->update($id, $request->validated());
            return response()->json($customer, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
