<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Language;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'cover_image' => $this->faker->word(),
            'edition' => $this->faker->word(),
            'genre_id' => Genre::factory(),
            'published' => $this->faker->date(),
            'language_id' => Language::factory(),
            'type' => $this->faker->randomElement(["e-book","physical"]),
            'file' => $this->faker->word(),
            'available' => $this->faker->boolean(),
        ];
    }
}
