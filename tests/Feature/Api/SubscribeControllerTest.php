<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use JWTAuth;


class SubscribeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $question;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user= \App\Models\User::factory()->create();
        $this->token= JWTAuth::fromUser($this->user);
        $this->question= \App\Models\Question::factory()->create();
    }

    /** @test  */
    public function logged_in_user_can_subscribe_to_a_question()
    {
        $response=$this->withHeaders(['Authorization' => "Bearer {$this->token}",])->json('GET',"api/questions/{$this->question->id}/subscribe");
        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'message' => 'You have successfully subscribed to  question'
            ]);
    }



}
