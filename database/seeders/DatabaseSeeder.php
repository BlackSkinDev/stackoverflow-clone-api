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
            ]);
        });
    }
}
