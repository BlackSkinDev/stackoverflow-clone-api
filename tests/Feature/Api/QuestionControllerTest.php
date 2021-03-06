<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Http\Response;
use JWTAuth;


class QuestionControllerTest extends TestCase
{
   use RefreshDatabase;

    protected $user;
    protected $token;
    protected $faker;
    protected $question;

    protected function setUp(): void
    {

        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user= \App\Models\User::factory()->create();
        $this->token= JWTAuth::fromUser($this->user);
        $this->faker=\Faker\Factory::create();
        $this->question= \App\Models\Question::factory()->create();
    }


    /** @test  */
    public function logged_in_user_can_ask_question()
    {
        $response=$this->withHeaders(['Authorization' => "Bearer {$this->token}",])->json('POST','api/questions/create',[
            'title'=>$title= $this->faker->text(50),
            'body'=>$this->faker->text(),
            'tags'=>implode(",", $this->faker->randomElements(['php', 'javascript', 'vue'], 2)),
            'slug'=>Str::slug($title, '-')
        ]);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertExactJson([
                'message' => 'Question saved successfully'
            ]);
    }

    /** @test  */
    public function logged_in_user_can_upvote_a_question(){

        $response=$this->withHeaders(['Authorization' => "Bearer {$this->token}",])->json('GET',"api/questions/{$this->question->id}/upvote");
        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'message' => 'You just upvoted question'
            ]);

    }

    /** @test  */
    public function logged_in_user_can_downvote_a_question(){

        $response=$this->withHeaders(['Authorization' => "Bearer {$this->token}",])->json('GET',"api/questions/{$this->question->id}/downvote");
        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'message' => 'You just downvoted question'
            ]);

    }

    /** @test  */
    public function logged_in_user_can_view_a_question(){
        $response=$this->withHeaders(['Authorization' => "Bearer {$this->token}",])->json('GET',"api/questions/{$this->question->id}");
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'question' => [
                    'id',
                    'title',
                    'body',
                    'tags',
                    'slug',
                    'created_at',

                ]
            ]);


    }


}
