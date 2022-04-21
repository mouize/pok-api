<?php

declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UpdateProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected const ROUTE_NAME = 'v1.products.update';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $this->route = route(static::ROUTE_NAME, ['product' => $product->id]);
        $this->formData = [
            'name' => $this->faker->firstName,
        ];
    }

    /**
     * @test
     */
    public function can_update_a_product(): void
    {
        $this
            ->putJson($this->route, $this->formData)
            ->assertOk();

        $this->assertDatabaseHas('products', [
            'name' => $this->formData['name'],
        ]);
    }
}
