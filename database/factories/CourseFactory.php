<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence,
            "sub_title" => $this->faker->sentence,
            "content" => "<p>" . implode("</p><p>", $this->faker->paragraphs()) . "</p>",
            "price" => 5000
        ];
    }
}
