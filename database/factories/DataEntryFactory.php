<?php

namespace Database\Factories;

use App\Models\DataEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $metaData = [
            'calls_dialed' => $this->faker->numberBetween(0,300),
            'conversations' => $this->faker->numberBetween(0,300),
            'rating_questions_asked' => $this->faker->numberBetween(0,300),
            'dollars_taken' => $this->faker->numberBetween(0,300),
            'units_sold' => $this->faker->numberBetween(0,300),
            'google_uploads' => $this->faker->numberBetween(0,300),
            'product_review_uploads' => $this->faker->numberBetween(0,300)
        ];
        $tmp = $this->faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now', $timezone = 'Australia/Melbourne');
        $tmp = $tmp->format('Y-m-d');
        $dateTime = $tmp . ' ' . $this->faker->randomElement(['11:00','13:00','15:30','17:30']);
        return [
            'entry_date' => $dateTime,
            'user_id' => User::inRandomOrder()->first()->id,
            'meta_data' => json_encode($metaData),
        ];
    }
}
