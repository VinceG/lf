<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $file = File::factory()->create(['post_id' => $post->id]);
            $post->update(['main_image' => $file->id]);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'title' => $this->faker->unique()->sentence(6),
            'body' => $this->faker->unique()->sentence(200),
            'owner_id' => function (array $attributes) {
                return User::inRandomOrder()->first()->id;
            }
        ];
    }
}
