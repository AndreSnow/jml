<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(protected \App\Services\SupplierService $service)
    {
    }

    public function store(StoreSupplierRequest $storeSupplierRequest)
    {
        $supplier = $this->service->create($storeSupplierRequest->validated());

        return response()->json(new SupplierResource($supplier), 201);
    }

    public function index(Request $request)
    {
        $suppliers = $this->service->search($request->query('q'));

        return response()->json(SupplierResource::collection($suppliers));
    }

    public function show($id)
    {
        $supplier = $this->service->find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        return response()->json(new SupplierResource($supplier));
    }

    public function update(UpdateSupplierRequest $updateSupplierRequest, $id)
    {
        $supplier = $this->service->update($id, $updateSupplierRequest->validated());
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        return response()->json(new SupplierResource($supplier));
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        return response()->json(null, 204);
    }
}
