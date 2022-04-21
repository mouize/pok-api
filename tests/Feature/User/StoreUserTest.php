<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class StoreUserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected const ROUTE_NAME = 'v1.users.store';

    protected function setUp(): void
    {
        parent::setUp();

        $this->route = route(static::ROUTE_NAME);
        $this->formData = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];
    }

    /**
     * @test
     */
    public function can_store_a_user(): void
    {
        $this
            ->postJson($this->route, $this->formData)
            ->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => $this->formData['name'],
            'email' => $this->formData['email'],
        ]);
    }

    /**
     * @test
     */
    public function can_not_store_a_user_with_an_email_that_already_exists(): void
    {
        $this->formData['email'] = 'john@doe.com';

        User::factory()->create(['email' => $this->formData['email']]);

        $this
            ->postJson($this->route, $this->formData)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }
}
