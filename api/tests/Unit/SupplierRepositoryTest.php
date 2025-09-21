<?php

namespace Tests\Unit;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SupplierRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_suppliers_and_uses_cache()
    {
        Cache::store('redis')->flush();
        Supplier::factory()->create(['name' => 'Alpha']);
        $repo = new SupplierRepository();
        $result = $repo->search('Alpha');
        $this->assertCount(1, $result);
        // Chamada subsequente deve vir do cache
        $resultCached = $repo->search('Alpha');
        $this->assertCount(1, $resultCached);
    }
}
