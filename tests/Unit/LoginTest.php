<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

}
