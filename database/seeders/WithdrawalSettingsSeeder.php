<?php

// database/seeders/WithdrawalSettingsSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\WithdrawalSetting;

class WithdrawalSettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'cryptocurrency' => 'BTC',
                'fixed_fee' => 0.0001,
                'percent_fee' => 0.1,
                'min_amount' => 0.0005,
                'max_amount' => 10,
                'networks' => ['Bitcoin'],  // only Bitcoin network
            ],
            [
                'cryptocurrency' => 'ETH',
                'fixed_fee' => 0.005,
                'percent_fee' => 0.2,
                'min_amount' => 0.01,
                'max_amount' => 100,
                'networks' => ['Ethereum', 'Arbitrum', 'Optimism', 'Polygon'],  // multiple chains
            ],
            [
                'cryptocurrency' => 'USDT',
                'fixed_fee' => 1,
                'percent_fee' => 0.3,
                'min_amount' => 10,
                'max_amount' => 100000,
                'networks' => ['Ethereum', 'Tron', 'BSC (BEP20)', 'Polygon', 'Solana'],
            ],
            [
                'cryptocurrency' => 'USDC',
                'fixed_fee' => 1,
                'percent_fee' => 0.25,
                'min_amount' => 10,
                'max_amount' => 100000,
                'networks' => ['Ethereum', 'Polygon', 'Arbitrum', 'Optimism', 'Solana', 'BSC (BEP20)'],
            ],
            [
                'cryptocurrency' => 'LTC',
                'fixed_fee' => 0.01,
                'percent_fee' => 0.1,
                'min_amount' => 0.1,
                'max_amount' => 1000,
                'networks' => ['Litecoin'],
            ],
            [
                'cryptocurrency' => 'DOGE',
                'fixed_fee' => 1,
                'percent_fee' => 0.1,
                'min_amount' => 10,
                'max_amount' => 100000,
                'networks' => ['Dogecoin'],
            ],
            [
                'cryptocurrency' => 'XRP',
                'fixed_fee' => 0.5,
                'percent_fee' => 0.15,
                'min_amount' => 1,
                'max_amount' => 50000,
                'networks' => ['XRP Ledger'],
            ],
            [
                'cryptocurrency' => 'ADA',
                'fixed_fee' => 0.2,
                'percent_fee' => 0.1,
                'min_amount' => 1,
                'max_amount' => 50000,
                'networks' => ['Cardano'],
            ],
            [
                'cryptocurrency' => 'SOL',
                'fixed_fee' => 0.01,
                'percent_fee' => 0.2,
                'min_amount' => 0.1,
                'max_amount' => 10000,
                'networks' => ['Solana'],
            ],
            [
                'cryptocurrency' => 'AVAX',
                'fixed_fee' => 0.02,
                'percent_fee' => 0.15,
                'min_amount' => 0.1,
                'max_amount' => 5000,
                'networks' => ['Avalanche (C-Chain)'],
            ],
            [
                'cryptocurrency' => 'MATIC',
                'fixed_fee' => 0.5,
                'percent_fee' => 0.2,
                'min_amount' => 5,
                'max_amount' => 50000,
                'networks' => ['Polygon'],
            ],
            [
                'cryptocurrency' => 'DOT',
                'fixed_fee' => 0.05,
                'percent_fee' => 0.2,
                'min_amount' => 1,
                'max_amount' => 10000,
                'networks' => ['Polkadot'],
            ],
            [
                'cryptocurrency' => 'LINK',
                'fixed_fee' => 0.2,
                'percent_fee' => 0.25,
                'min_amount' => 1,
                'max_amount' => 20000,
                'networks' => ['Ethereum', 'Polygon', 'Arbitrum'],
            ],
            [
                'cryptocurrency' => 'DAI',
                'fixed_fee' => 0.5,
                'percent_fee' => 0.2,
                'min_amount' => 5,
                'max_amount' => 50000,
                'networks' => ['Ethereum', 'Polygon', 'Arbitrum', 'Optimism'],
            ],
            [
                'cryptocurrency' => 'BUSD',
                'fixed_fee' => 0.5,
                'percent_fee' => 0.2,
                'min_amount' => 5,
                'max_amount' => 50000,
                'networks' => ['BSC (BEP20)', 'Ethereum'],
            ],
        ];

        foreach ($data as $row) {
            WithdrawalSetting::updateOrCreate(
                ['cryptocurrency' => $row['cryptocurrency']],
                $row
            );
        }
    }
}
