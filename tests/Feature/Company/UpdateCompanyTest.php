<?php

declare(strict_types=1);

namespace Tests\Feature\Product;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UpdateCompanyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected const ROUTE_NAME = 'v1.companies.update';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());

        $company = Company::factory()->create();
        $this->route = route(static::ROUTE_NAME, ['company' => $company->id]);
        $this->formData = [
            'name' => $this->faker->firstName,
        ];
    }

    /**
     * @test
     */
    public function can_update_a_company(): void
    {
        $this
            ->putJson($this->route, $this->formData)
            ->assertOk();

        $this->assertDatabaseHas('companies', [
            'name' => $this->formData['name'],
        ]);
    }
}
