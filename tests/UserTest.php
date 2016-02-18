<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    
    public function __construct() {
        $user = new User(['name' => 'USER_NAME', 
                          'email' => 'USER@TEST.COM', 
                          'password' => 'ABCDEFGH']);
        

        //$this->be($user);
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIsExistCreateTaskPage()
    {
        $this->visit('/task/create')->see('create');
        
        
    }
}
