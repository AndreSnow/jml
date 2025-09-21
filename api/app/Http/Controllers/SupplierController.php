<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
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

        return (new SupplierResource($supplier))->response()->setStatusCode(201);
    }

    public function index(Request $request)
    {
        $suppliers = $this->service->search($request->query('q'));

        return SupplierResource::collection($suppliers);
    }
}