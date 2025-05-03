<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepositTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_create_deposit_when_enabled()
{
    $user = User::factory()->create();
    SiteSetting::set('deposits_enabled', '1');

    $response = $this->actingAs($user)
        ->post(route('deposit.store'), [
            'amount' => 100,
            'currency' => 'USD',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('deposits', ['user_id' => $user->id, 'amount' => 100]);
}

public function test_user_cannot_create_deposit_when_disabled()
{
    $user = User::factory()->create();
    SiteSetting::set('deposits_enabled', '0');

    $response = $this->actingAs($user)
        ->get(route('deposit.create'));

    $response->assertRedirect(route('dashboard'))
        ->assertSessionHasErrors('Deposits are currently disabled.');
}

}
