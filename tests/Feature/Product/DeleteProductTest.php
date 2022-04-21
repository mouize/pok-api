<?php

declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE_NAME = 'v1.products.destroy';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function can_delete_a_product(): void
    {
        $product = Product::factory()->create();

        $this
            ->deleteJson(route(static::ROUTE_NAME, ['product' => $product->id]))
            ->assertNoContent();

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
