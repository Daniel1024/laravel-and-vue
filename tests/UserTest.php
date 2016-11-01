<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testExample()
    {
        factory(\App\User::class)->create(['name' => 'Daniel']);

        $this->get('name')
            ->assertResponseOk()
            ->seeText('Daniel');
    }
}
