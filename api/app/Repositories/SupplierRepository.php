<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Support\Facades\Cache;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function search(?string $query = null)
    {
        $cacheKey = 'suppliers_search_' . md5($query ?? 'all');
        return Cache::store('redis')->remember($cacheKey, 60, function () use ($query) {
            return Supplier::when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })->latest()->get();
        });
    }
}
