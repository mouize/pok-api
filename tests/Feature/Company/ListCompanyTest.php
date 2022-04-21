<?php

declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ListCompanyTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE_NAME = 'v1.companies.index';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function can_list_companies(): void
    {
        Company::factory()->count(4)->create();

        $this
            ->getJson(route(static::ROUTE_NAME))
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'description',
                    ],
                ],
            ]);
    }
}
