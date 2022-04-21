<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ShowUserTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE_NAME = 'v1.users.show';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function can_show_a_user(): void
    {
        $user = User::factory()->create();

        $this
            ->getJson(route(static::ROUTE_NAME, ['user' => $user->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'email_verified_at',
                ],
            ]);
    }
}
