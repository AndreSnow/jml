<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Supplier;

class SupplierApiCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_suppliers()
    {
        Supplier::factory()->count(2)->create();
        $response = $this->getJson('/api/suppliers');
        $response->assertStatus(200);
        $this->assertCount(2, $response->json());
    }

    public function test_can_show_supplier()
    {
        $supplier = Supplier::factory()->create();
        $response = $this->getJson('/api/suppliers/' . $supplier->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $supplier->id]);
    }

    public function test_show_returns_404_for_missing_supplier()
    {
        $response = $this->getJson('/api/suppliers/999');
        $response->assertStatus(404);
    }

    public function test_can_update_supplier()
    {
        $supplier = Supplier::factory()->create(['name' => 'Old Name']);
        $payload = ['name' => 'New Name'];
        $response = $this->putJson('/api/suppliers/' . $supplier->id, $payload);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'New Name']);
        $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'name' => 'New Name']);
    }

    public function test_update_returns_404_for_missing_supplier()
    {
        $payload = ['name' => 'New Name'];
        $response = $this->putJson('/api/suppliers/999', $payload);
        $response->assertStatus(404);
    }

    public function test_can_delete_supplier()
    {
        $supplier = Supplier::factory()->create();
        $response = $this->deleteJson('/api/suppliers/' . $supplier->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('suppliers', ['id' => $supplier->id]);
    }

    public function test_delete_returns_404_for_missing_supplier()
    {
        $response = $this->deleteJson('/api/suppliers/999');
        $response->assertStatus(404);
    }
}
