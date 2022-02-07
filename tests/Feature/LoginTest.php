<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_user_can_view_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function test_user_cannot_view_login_form_when_authenticated()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    public function test_no_login_if_user_doesnt_exist()
    {
        $response = $this->from(route('login'))
            ->post(route('login'), [
                'email' => 'demo@email.com',
                'password' => 'demoPassword',
            ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'profile_url' => 'demo.png'
        ]);
        $this->be($user);

        $this->post(route('logout'));
        $this->assertGuest();
    }
}
