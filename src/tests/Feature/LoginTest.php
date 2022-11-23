<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\MessageBag;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_success()
    {
        $this->assertGuest();

        $response = $this->post('/en/login',[
            'email' => 'nhutltm@vn.ids.jp',
            'password' => 'Minhnhut75',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
        $response->assertRedirect('/en/timesheets');
    }

    public function test_login_fail()
    {
        $this->assertGuest();

        $response = $this->post('/en/login',[
            'email' => '123@gmail',
            'password' => '123'
        ]);

        $response->assertStatus(302)->assertSessionHasErrors('login_failed');
    }

    public function test_login_without_email_pass()
    {
        $this->assertGuest();

        $response = $this->post('/en/login',[
            'email' => 'dsad@das',
            'password' => null,
        ]);

        //dd(session()->all());
        $response->assertStatus(302);
    }
}
