<?php

namespace Database\Factories;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */ 
class BookFactory extends Factory
{
    protected $model = Book::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            'title' => fake()->sentence(2),
            'author' => fake()->name(),
            'genre' => fake()->userName(),
            'description' => fake()->paragraph(2),
            'isbn' => fake()->randomDigit(),
            'image' => 'placeholder.png',
            'published' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'publisher' => fake()->name(),
        ];

    }
}
