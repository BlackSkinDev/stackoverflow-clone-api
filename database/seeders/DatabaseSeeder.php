<?php

namespace Database\Seeders;

use Faker\Factory;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    protected $faker;

    public function __construct(){
        $this->faker=  \Faker\Factory::create();
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \App\Models\User::factory(10)->create();


        \App\Models\Question::factory(3)->create()->each(function ($question){
            \App\Models\Answer::factory(3)->create([
                'answer'=>$this->faker->text(50),
                'user_id'=>$question->user_id,
                'question_id'=>$question->id
            ])->each(function ($answer){
                $key=['question_id','answer_id'];
                $key=$key[array_rand($key)];
                if ($key=='question_id'){
                    $value=$answer->question_id;
                }
                else{
                    $value=$answer->id;
                }
               \App\Models\Vote::factory(3)->create([
                    $key=> $value,
                    'user_id'=>$answer->user_id,
                    'status'=>rand(0,1)
               ]);
            });
        });
    }
}
