<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierService
{
    public function __construct(protected \App\Repositories\SupplierRepositoryInterface $repository)
    {
    }

    public function create(array $data): Supplier
    {
        return DB::transaction(function () use ($data): \App\Models\Supplier {
            $data['cnpj'] = preg_replace('/\D+/', '', (string) $data['cnpj']);

            return $this->repository->create($data);
        });
    }

    public function search(string $query = null)
    {
        return $this->repository->search($query);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
