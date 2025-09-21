<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Support\Facades\Cache;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function create(array $data): Supplier
    {
        $supplier = Supplier::create($data);
        $this->clearSearchCache();
        return $supplier;
    }

    public function search(?string $query = null)
    {
        $cacheKey = 'suppliers_search_' . md5($query ?? 'all');
        return Cache::store('redis')->remember($cacheKey, 60, fn () => Supplier::when($query, function ($q) use ($query): void {
            $q->where('name', 'like', sprintf('%%%s%%', $query));
        })->latest()->get());
    }

    public function find($id)
    {
        return Supplier::find($id);
    }

    public function update($id, array $data)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return null;
        }

        $supplier->update($data);
        $this->clearSearchCache();

        return $supplier;
    }

    public function delete($id): bool
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return false;
        }

        $supplier->delete();
        $this->clearSearchCache();

        return true;
    }

    protected function clearSearchCache()
    {
        foreach (Cache::store('redis')->getRedis()->keys('suppliers_search_*') as $key) {
            Cache::store('redis')->forget(str_replace(Cache::store('redis')->getRedis()->getOption(2), '', $key));
        }
    }
}
