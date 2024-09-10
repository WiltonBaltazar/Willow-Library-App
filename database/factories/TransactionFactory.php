<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'user_id' => User::factory(),
            'borrowed_date' => $this->faker->date(),
            'returned_date' => $this->faker->date(),
            'borrowed_for' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->randomElement(["pending","returned"]),
        ];
    }
}
