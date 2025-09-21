<?php

namespace App\Repositories;

use App\Models\Supplier;

interface SupplierRepositoryInterface
{
    public function create(array $data): Supplier;

    public function search(?string $query = null);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);
}
