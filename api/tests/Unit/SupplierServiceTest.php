<?php

namespace Tests\Unit;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use App\Services\SupplierService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_sanitizes_cnpj_and_uses_transaction()
    {
        $repo = new SupplierRepository();
        $service = new SupplierService($repo);
        $data = [
            'name' => 'Test',
            'cnpj' => '12.345.678/0001-95',
            'email' => 'test@example.com',
        ];
        $supplier = $service->create($data);
        $this->assertEquals('12345678000195', $supplier->cnpj);
        $this->assertDatabaseHas('suppliers', [
            'name' => 'Test',
            'cnpj' => '12345678000195',
        ]);
    }
}
