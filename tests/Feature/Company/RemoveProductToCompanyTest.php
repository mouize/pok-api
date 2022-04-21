<?php

declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Company;
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
class RemoveProductToCompanyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected const ROUTE_NAME = 'v1.companies.product.destroy';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function can_remove_product_from_company(): void
    {
        $company = Company::factory()->create();
        $product = Product::factory()->create();
        $route = route(static::ROUTE_NAME, ['company' => $company->id, 'product' => $product->id]);

        $this
            ->deleteJson($route)
            ->assertNoContent();

        $this->assertNotContains($product->id, $company->products->pluck('id'));
    }
}
