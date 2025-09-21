<?php

namespace App\Repositories;

use App\Models\Supplier;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function search(?string $query = null)
    {
        return Supplier::when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%");
        })->latest()->get();
    }
}
