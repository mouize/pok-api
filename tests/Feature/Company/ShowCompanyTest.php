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
class ShowCompanyTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE_NAME = 'v1.companies.show';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function can_show_a_company(): void
    {
        $company = Company::factory()->create();

        $this
            ->getJson(route(static::ROUTE_NAME, ['company' => $company->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'description',
                ],
            ]);
    }
}
