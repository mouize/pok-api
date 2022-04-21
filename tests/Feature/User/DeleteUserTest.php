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
class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE_NAME = 'v1.users.destroy';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function can_delete_a_user(): void
    {
        $user = User::factory()->create();

        $this
            ->deleteJson(route(static::ROUTE_NAME, ['user' => $user->id]))
            ->assertNoContent();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
