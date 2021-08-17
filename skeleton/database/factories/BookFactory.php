<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

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
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(50),
            'description' => $this->faker->paragraphs(2, true),
            'created_at' => now(),
            'published' => true,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $this->attachAuthors($book);
        });
    }

    protected function attachAuthors(Book $book)
    {
        $authors = Author::all()->pluck('id');
        $withPosition = [];
        $position = 1;

        foreach ($this->faker->randomElements($authors, rand(0, 3)) as $id) {
            $withPosition[$id] = ['position' => $position++];
        };

        $book->authors()->sync($withPosition);
    }
}
