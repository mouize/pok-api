<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UpdateUserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected const ROUTE_NAME = 'v1.users.update';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());

        $user = User::factory()->create();
        $this->route = route(static::ROUTE_NAME, ['user' => $user->id]);
        $this->formData = [
            'name' => $this->faker->firstName,
        ];
    }

    /**
     * @test
     */
    public function can_update_a_user(): void
    {
        $this
            ->putJson($this->route, $this->formData)
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => $this->formData['name'],
        ]);
    }
}
