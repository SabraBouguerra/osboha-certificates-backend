<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thesis>
 */
class ThesisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reviews'=>$this->faker->paragraph,
            'degree'=> $this->faker->paragraph,
            'reviewer_id',
            'auditor_id',
            'thesis_text',
            'starting_page',
            'ending_page',
            'user_book_id'
        
        ];
    }
}
