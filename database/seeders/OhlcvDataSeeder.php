<?php

namespace Database\Seeders;

use App\Models\OhlcvData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OhlcvDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the date range for your mock data
        $startDate = Carbon::create(2023, 7, 26, 0, 0, 0); // Approx. 2 years ago from now
        $endDate = Carbon::now()->subDay(); // Up to yesterday (as "today" is often incomplete for daily)

        // Generate mock daily data for BTC/USDT
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            // Ensure unique timestamp for each day
            OhlcvData::factory()
                ->specificPair('BTC/USDT', 'crypto', '1d')
                ->state([
                    'timestamp' => $currentDate->format('Y-m-d H:i:s'), // Set specific date
                ])
                ->create();

            $currentDate->addDay(); // Move to the next day
        }

        $this->command->info('Mock daily OHLCV data for BTC/USDT seeded successfully!');

        // You could add more pairs or intervals here if needed
        // For example, mock data for ETH/USDT daily for the same period:
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            OhlcvData::factory()
                ->specificPair('ETH/USDT', 'crypto', '1d')
                ->state([
                    'timestamp' => $currentDate->format('Y-m-d H:i:s'),
                    'open' => $this->faker->randomFloat(2, 1500, 2500), // ETH price range
                    'high' => $this->faker->randomFloat(2, 1500, 2500),
                    'low' => $this->faker->randomFloat(2, 1500, 2500),
                    'close' => $this->faker->randomFloat(2, 1500, 2500),
                ])
                ->create();
            $currentDate->addDay();
        }
         $this->command->info('Mock daily OHLCV data for ETH/USDT seeded successfully!');
    }
}