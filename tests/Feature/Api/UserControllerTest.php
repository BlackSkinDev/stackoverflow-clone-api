<?php

namespace Tests\Feature\Api;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;


class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test  */
    public function user_can_register()
    {
        $faker=\Faker\Factory::create();
        $response = $this->json('POST','/api/auth/register',[
            'name'=>$faker->name,
            'email' =>$faker->safeEmail,
            'password'=>$password= '1234567'
        ]);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'message' => 'Account Created Successfully'
            ]);

    }

    /** @test */
    public function user_login(){
        $user= \App\Models\User::factory()->create();
        $loginData = ['email' => $user->email, 'password' => 'password'];
        $response= $this->json('POST','api/auth/login',$loginData);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['token']);

    }
}
