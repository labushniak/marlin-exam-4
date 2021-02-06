<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase

{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_accessHomePage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('users');
        $response->assertSeeText("Список пользователей", $escaped = true);
    }

    public function test_accessLoginPage()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('login');
        $response->assertSeeText("Login", $escaped = true);
    }

    public function test_accessRegistrationPage()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('register');
        $response->assertSeeText("Регистрация", $escaped = true);
    }

    public function test_userCanNotViewLoginWhenAuthentficated() { 
        $user = User::factory()->create();
  
        $response = $this->actingAs($user)->get('login'); 
        $response->assertRedirect('/'); 
    }

    public function test_userCanNotViewRegistrationWhenAuthentficated() { 
        $user = User::factory()->create();
  
        $response = $this->actingAs($user)->get('register'); 
        $response->assertRedirect('/'); 
    }

    public function test_userCanLoginWithCorrectCredentials() { 
        $password = '123password'; 
  
        $user = User::factory()->create([ 
            'password' => bcrypt($password) 
        ]); 
  
        $response = $this->post('/login',[ 
            'email' => $user->email, 
            'password' =>$password, 
        ]); 
  
        $response->assertRedirect('/'); 
        $this->assertAuthenticatedAs($user); 
    }

    public function test_userCanNotLoginWithInCorrectCredentials() { 
        $password = '123password'; 
  
        $user = User::factory()->create([ 
            'password' => bcrypt($password) 
        ]); 
  
        $response = $this->from('/login')->post('/login',[ 
            'email' => $user->email, 
            'password' => 'wrong password', 
        ]); 
  
        $response->assertRedirect('/login'); 
        $response->assertSessionHasErrors('email'); 
        $response->assertSessionHasErrors(['email' => 'Email or password are invalid.']); 
        $this->assertGuest();
  
    }
    
    public function test_userRememberMe() { 
        $password = '123password';

        $user = User::factory()->create([ 
            'id' => random_int(1,100), 
            'password' => bcrypt($password) 
        ]); 
  
        $response = $this->post('/login',[ 
            'email' => $user->email, 
            'password' =>$password, 
            'remember' => 'on' 
        ]); 
  
        $response->assertRedirect('/'); 
        $this->assertAuthenticatedAs($user); 
  
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf("%s|%s|%s",[ 
            $user->id, 
            $user->getRememberToken(), 
            $user->password 
        ])); 
  
    }
    
    public function test_guestUserCannotSeeProfilePage(){
        $id = random_int(1,100);
        
        User::factory()->create([ 
            'id' => $id
        ]); 
        
        $url = '/profile/' . $id;

        $response = $this->get($url);

        $response->assertRedirect('/login'); 
        $this->assertGuest();
    }

    public function test_guestUserCannotSeeEditPage(){
        $id = random_int(1,100);
        
        User::factory()->create([ 
            'id' => $id
        ]); 
        
        $url = '/edit/' . $id;

        $response = $this->get($url);

        $response->assertRedirect('/login'); 
        $this->assertGuest();
    }

    public function test_guestUserCannotSeeSecurityPage(){
        $id = random_int(1,100);
        
        User::factory()->create([ 
            'id' => $id
        ]); 
        
        $url = '/security/' . $id;

        $response = $this->get($url);

        $response->assertRedirect('/login'); 
        $this->assertGuest();
    }
    
    public function test_guestUserCannotSeeStatusPage(){
        $id = random_int(1,100);
        
        User::factory()->create([ 
            'id' => $id
        ]); 
        
        $url = '/status/' . $id;

        $response = $this->get($url);

        $response->assertRedirect('/login'); 
        $this->assertGuest();
    }
    
    public function test_guestUserCannotSeeAvatarPage(){
        $id = random_int(1,100);
        
        User::factory()->create([ 
            'id' => $id
        ]); 
        
        $url = '/avatar/' . $id;

        $response = $this->get($url);

        $response->assertRedirect('/login'); 
        $this->assertGuest();
    }

    public function test_guestUserCannotDeleteOtherUser(){
        $id = random_int(1,100);
        
        User::factory()->create([ 
            'id' => $id
        ]); 
        
        $url = '/delete/' . $id;

        $response = $this->get($url);

        $response->assertRedirect('/login'); 
        $this->assertGuest();
    }
    

}
