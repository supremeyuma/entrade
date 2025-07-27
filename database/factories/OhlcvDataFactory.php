<?php

namespace Database\Factories;

use App\Models\OhlcvData;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OhlcvDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OhlcvData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // Define common base price for realistic mock data
        $basePrice = $this->faker->randomFloat(2, 25000, 35000); // BTC/USDT range

        // Ensure high >= open, low <= open, and close is within range
        $open = $basePrice;
        $close = $this->faker->randomFloat(2, $open * 0.99, $open * 1.01); // within 1% of open
        $high = max($open, $close, $this->faker->randomFloat(2, $open * 1.005, $open * 1.02)); // high is always >= open/close
        $low = min($open, $close, $this->faker->randomFloat(2, $open * 0.98, $open * 0.995)); // low is always <= open/close

        return [
            'symbol' => 'BTC/USDT', // Or use faker for various symbols
            'market_type' => 'crypto',
            'interval' => '1d', // Ensure this matches the daily data interval
            'timestamp' => Carbon::parse($this->faker->dateTimeBetween('-2 years', 'now')), // Daily data for up to 2 years
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'close' => $close,
            'volume' => $this->faker->randomFloat(4, 1000, 100000), // Mock volume
        ];
    }

    // You can define states for different scenarios, e.g., a "winning" candle state
    public function winning(): Factory
    {
        return $this->state(function (array $attributes) {
            $open = $attributes['open'];
            $close = $this->faker->randomFloat(2, $open * 1.01, $open * 1.03); // Close higher than open
            $high = $this->faker->randomFloat(2, $close * 1.001, $close * 1.005);
            $low = $this->faker->randomFloat(2, $open * 0.99, $open);
            return [
                'open' => $open,
                'high' => $high,
                'low' => $low,
                'close' => $close,
            ];
        });
    }

    // You can define states for a "losing" candle state
    public function losing(): Factory
    {
        return $this->state(function (array $attributes) {
            $open = $attributes['open'];
            $close = $this->faker->randomFloat(2, $open * 0.97, $open * 0.99); // Close lower than open
            $high = $this->faker->randomFloat(2, $open * 1.001, $open);
            $low = $this->faker->randomFloat(2, $close * 0.995, $close);
            return [
                'open' => $open,
                'high' => $high,
                'low' => $low,
                'close' => $close,
            ];
        });
    }

    public function specificPair(string $symbol, string $marketType, string $interval): Factory
    {
        return $this->state(function (array $attributes) use ($symbol, $marketType, $interval) {
            return [
                'symbol' => $symbol,
                'market_type' => $marketType,
                'interval' => $interval,
            ];
        });
    }
}