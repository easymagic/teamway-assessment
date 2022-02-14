<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkPlanningServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     ///Please run "php artisan migrate --seed" before this unit test.

    public function test_users_endpoint()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(200);
    }

    public function test_user_shift()
    {
        $response = $this->get('/api/users/1/shifts');
        $response->assertStatus(200);
    }

    public function test_get_user()
    {
        $response = $this->get('api/users/1');
        $response->assertStatus(200);
    }


    public function test_update_user_account()
    {
        $response = $this->post('api/users/1/accounts',[
            'name'=>'Test User'
        ]);
        $response->assertStatus(200);
    }


    public function test_get_user_current_shift()
    {
        $response = $this->get('api/users/1/shifts/current');
        $response->assertStatus(200);
    }

    public function test_user_shift_is_the_current_shift_for_that_user()
    {
        $response = $this->get('api/users/1/shifts/1/current');
        $response->assertStatus(200);
    }

    public function test_get_user_shift()
    {
        $response = $this->get('api/users/1/shifts');
        $response->assertStatus(200);
    }

    public function test_add_shift_to_user()
    {
        $response = $this->post('api/users/1/shifts',[
            'shift_id'=>1
        ]);
        $response->assertStatus(200);
    }

    public function test_remove_shift_from_user()
    {
        $response = $this->delete('api/users/1/shifts',[
            'shift_id'=>1
        ]);
        $response->assertStatus(200);
    }

    public function test_get_shift()
    {
        $response = $this->get('api/shifts');
        $response->assertStatus(200);
    }

    public function test_get_shift_by_id()
    {
        $response = $this->get('api/shifts/1');
        $response->assertStatus(200);
    }

    public function test_get_shift_users()
    {
        $response = $this->get('api/shifts/1/users');
        $response->assertStatus(200);
    }

    public function test_get_current_active_shift()
    {
        $response = $this->get('api/shifts:current');
        $response->assertStatus(200);
    }

    public function test_get_current_active_shift_users()
    {
        $response = $this->get('api/shifts:current/users');
        $response->assertStatus(200);
    }

    public function test_current_active_shift_users_belongs_to_current_shift()
    {
        $response = $this->get('api/shifts:current/users/1');
        $response->assertStatus(200);
    }

}
