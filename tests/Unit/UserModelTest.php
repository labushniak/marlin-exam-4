<?php

namespace Tests\Unit;
use App\Models\User;
use App\Models\UsersInfo;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\UsersLinks;

class UserModelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_UserModel()
    {
        
        $job_title = Str::random(10);
        $id = random_int(1,100);
        $email = Str::random(7) . '@mail.com';
        $vk = Str::random(10);

        User::factory()->create([
            'id'=> $id,
            'email' => $email
        ]);

        UsersLinks::factory()->create([
            'user_id' => $id,
            'vk' => $vk
        ]);

        UsersInfo::factory()->create([
            'user_id' => $id,
            'job_title' => $job_title
        ]);
        

        $this->assertDatabaseHas('users', [
            'id'=> $id,
            'email' => $email,
        ]);

        $this->assertDatabaseHas('users_links', [
            'user_id' => $id,
            'vk' => $vk,
        ]);

        $this->assertDatabaseHas('users_info', [
            'user_id' => $id,
            'job_title' => $job_title
        ]);

        
    }
}
