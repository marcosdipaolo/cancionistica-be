<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /** @var string $model */
    protected $model = Post::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence(),
            "sub_title" => $this->faker->sentence(),
            "content" => $this->faker->text(2000),
            "image_url" => "https://source.unsplash.com/random"
        ];
    }
}
