<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIsExistWelcomePage()
    {
        $this->visit('/')->see('NuPtr');
    }
    
    public function testIsExistLoginPage(){
        $this->visit('/login')->see('Login');
    }
    
    public function testIsExistRegisterPage(){
        $this->visit('/register')->see('Register');
    }
    
    public function testIsExistContactTaskPage(){
        $this->visit('/contact')->see('contact');
    }
}
