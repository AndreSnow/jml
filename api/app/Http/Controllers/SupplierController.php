<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $service;

    public function __construct(SupplierService $service)
    {
        $this->service = $service;
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = $this->service->create($request->validated());

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

    public function update(UpdateSupplierRequest $request, $id)
    {
        $supplier = $this->service->update($id, $request->validated());
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