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
            'created_at' => now(),
            'published' => true,
            "isbn" => $this->faker->randomNumber(8, true),
            "publication_date" => $this->faker->date('Y-m-d'),
            "formats" => $this->faker->randomElements([
                "hardcover",
                "paperback",
                "epub"
            ]),
            "topics" => $this->faker->randomElements([
                "arts",
                "finance",
                "civic",
            ]),
            "available" => $this->faker->randomElements([
                "available",
                "back-order",
                "out-of-print",
            ], 1),
            'forthcoming' => $this->faker->boolean(),
            'en' => [
                'title' => $this->faker->text(50),
                'description' => $this->faker->paragraphs(1, true),
                'subtitle' => $this->faker->text(50),
                'summary' => '<p>'.$this->faker->paragraph().'</p>',
                'active' => true,
            ],
            'fr' => [
                'title' => $this->faker->text(50),
                'description' => $this->faker->paragraphs(1, true),
                'subtitle' => $this->faker->text(50),
                'summary' => '<p>'.$this->faker->paragraph().'</p>',
                'active' => true,
            ],
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
