<?php

namespace App\Http\Controllers\Api;

use App\Http\Contracts\Api\SalesOrderRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesOrder\StoreRequest;
use Illuminate\Http\JsonResponse;

class SalesOrderController extends Controller
{
    protected $repo;

    public function __construct(SalesOrderRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @group Sales Order
     * @subgroup Create
     * @subgroupDescription Tambah data penjualan (sales order) beserta detail item.
     *
     * @bodyParam reference_no string Nomor referensi order. Example: SO-20240620-001
     * @bodyParam sales_id integer required ID sales. Example: 1
     * @bodyParam customer_id integer required ID customer. Example: 2
     * @bodyParam items array required Daftar item penjualan.
     * @bodyParam items[].product_id integer required ID produk. Example: 3
     * @bodyParam items[].quantity integer required Jumlah produk. Example: 10
     * @bodyParam items[].production_price number required Harga pokok. Example: 50000
     * @bodyParam items[].selling_price number required Harga jual. Example: 75000
     *
     * @response 201 scenario="Sukses"
     * {
     *   "id": 1,
     *   "reference_no": "SO-20240620-001",
     *   "sales_id": 1,
     *   "customer_id": 2,
     *   "sales_order_items": [
     *     {
     *       "id": 1,
     *       "product_id": 3,
     *       "quantity": 10,
     *       "production_price": "50000.00",
     *       "selling_price": "75000.00"
     *     }
     *   ]
     * }
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $order = $this->repo->store($request->validated());
            return response()->json($order, 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
