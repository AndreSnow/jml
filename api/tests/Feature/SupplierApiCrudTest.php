<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Supplier;

class SupplierApiCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_suppliers(): void
    {
        Supplier::factory()->count(2)->create();
        $testResponse = $this->getJson('/api/suppliers');
        $testResponse->assertStatus(200);
        $this->assertCount(2, $testResponse->json());
    }

    public function test_can_show_supplier(): void
    {
        $supplier = Supplier::factory()->create();
        $testResponse = $this->getJson('/api/suppliers/' . $supplier->id);
        $testResponse->assertStatus(200)
            ->assertJsonFragment(['id' => $supplier->id]);
    }

    public function test_show_returns_404_for_missing_supplier(): void
    {
        $testResponse = $this->getJson('/api/suppliers/999');
        $testResponse->assertStatus(404);
    }

    public function test_can_update_supplier(): void
    {
        $supplier = Supplier::factory()->create(['name' => 'Old Name']);
        $payload = ['name' => 'New Name'];
        $testResponse = $this->putJson('/api/suppliers/' . $supplier->id, $payload);
        $testResponse->assertStatus(200)
            ->assertJsonFragment(['name' => 'New Name']);
        $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'name' => 'New Name']);
    }

    public function test_update_returns_404_for_missing_supplier(): void
    {
        $payload = ['name' => 'New Name'];
        $testResponse = $this->putJson('/api/suppliers/999', $payload);
        $testResponse->assertStatus(404);
    }

    public function test_can_delete_supplier(): void
    {
        $supplier = Supplier::factory()->create();
        $testResponse = $this->deleteJson('/api/suppliers/' . $supplier->id);
        $testResponse->assertStatus(204);
        $this->assertSoftDeleted('suppliers', ['id' => $supplier->id]);
    }

    public function test_delete_returns_404_for_missing_supplier(): void
    {
        $testResponse = $this->deleteJson('/api/suppliers/999');
        $testResponse->assertStatus(404);
    }
}
