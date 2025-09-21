<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use App\Repositories\SupplierRepositoryInterface;

class SupplierService
{
    protected $repository;

    public function __construct(SupplierRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): Supplier
    {
        return DB::transaction(function () use ($data) {
            $data['cnpj'] = preg_replace('/\D+/', '', $data['cnpj']);

            return $this->repository->create($data);
        });
    }

    public function search(string $query = null)
    {
        return $this->repository->search($query);
    }
}