<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;


class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $title=$this->faker->text(50),
            'body' => $this->faker->text(200),
            'tags'=> implode(",", $this->faker->randomElements(['php', 'javascript', 'vue'], 2)),
            'slug'=> Str::slug($title),
            'user_id'=>User::factory(),
        ];
    }
}
