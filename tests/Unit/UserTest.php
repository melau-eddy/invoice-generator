<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register_users()
    {
        $response=$this->call('GET', '/');
        $response->assertStatus(302);
    }

    public function test_database()
    {
        $this->assertDatabaseMissing('users', ['name'=>'admina']);
    }
}
