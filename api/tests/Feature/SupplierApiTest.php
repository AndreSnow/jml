<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Supplier;

class SupplierApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_supplier_successfully(): void
    {
        $payload = [
            'name' => 'Test Company',
            'cnpj' => '12345678000195',
            'email' => 'test@company.com',
        ];

        $testResponse = $this->postJson('/api/suppliers', $payload);
        $testResponse->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Test Company',
                'cnpj' => '12345678000195',
                'email' => 'test@company.com',
            ]);
        $this->assertDatabaseHas('suppliers', [
            'name' => 'Test Company',
            'cnpj' => '12345678000195',
        ]);
    }

    public function test_validation_fails_for_short_name(): void
    {
        $payload = [
            'name' => 'AB',
            'cnpj' => '12345678000195',
            'email' => 'test@company.com',
        ];
        $testResponse = $this->postJson('/api/suppliers', $payload);
        $testResponse->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_validation_fails_for_invalid_cnpj(): void
    {
        $payload = [
            'name' => 'Test Company',
            'cnpj' => '11111111111111',
            'email' => 'test@company.com',
        ];
        $testResponse = $this->postJson('/api/suppliers', $payload);
        $testResponse->assertStatus(422)
            ->assertJsonValidationErrors(['cnpj']);
    }

    public function test_validation_fails_for_duplicate_cnpj(): void
    {
        Supplier::factory()->create(['cnpj' => '12345678000195']);
        $payload = [
            'name' => 'Another Company',
            'cnpj' => '12345678000195',
            'email' => 'another@company.com',
        ];
        $testResponse = $this->postJson('/api/suppliers', $payload);
        $testResponse->assertStatus(422)
            ->assertJsonValidationErrors(['cnpj']);
    }

    public function test_can_filter_suppliers_by_name(): void
    {
        Supplier::factory()->create(['name' => 'Alpha', 'cnpj' => '12345678000195']);
        Supplier::factory()->create(['name' => 'Beta', 'cnpj' => '12345678000196']);
        $testResponse = $this->getJson('/api/suppliers?q=Alpha');
        $testResponse->assertStatus(200)
            ->assertJsonFragment(['name' => 'Alpha'])
            ->assertJsonMissing(['name' => 'Beta']);
    }
}
