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
class ShowProductTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE_NAME = 'v1.products.show';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function can_show_a_product(): void
    {
        $product = Product::factory()->create();

        $this
            ->getJson(route(static::ROUTE_NAME, ['product' => $product->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'description',
                ],
            ]);
    }
}
