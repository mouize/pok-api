<?php

declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class StoreProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected const ROUTE_NAME = 'v1.products.store';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());

        $this->route = route(static::ROUTE_NAME);
        $this->formData = [
            'name' => $this->faker->firstName,
            'description' => $this->faker->text,
        ];
    }

    /**
     * @test
     */
    public function can_store_a_product(): void
    {
        $this
            ->postJson($this->route, $this->formData)
            ->assertCreated();

        $this->assertDatabaseHas('products', [
            'name' => $this->formData['name'],
            'description' => $this->formData['description'],
        ]);
    }
}
