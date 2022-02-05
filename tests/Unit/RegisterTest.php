<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Tests\RefreshDatabase;
use Faker\Generator as Faker;

class registerTest extends TestCase
{
    public function test_user_registration_form()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
        $response->assertSeeText('Login');
    }

}
