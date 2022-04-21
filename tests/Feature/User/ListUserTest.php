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
class ListUserTest extends TestCase
{
    use RefreshDatabase;

    protected const ROUTE_NAME = 'v1.users.index';

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    /**
     * @test
     */
    public function can_list_users(): void
    {
        User::factory()->count(4)->create();

        $this
            ->getJson(route(static::ROUTE_NAME))
            ->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'email',
                        'email_verified_at',
                    ],
                ],
            ]);
    }
}
