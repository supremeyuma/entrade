<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['title' => 'Getting Started', 'icon' => '🚀'],
            ['title' => 'Account & Settings', 'icon' => '⚙️'],
            ['title' => 'Copy Trading', 'icon' => '📈'],
            ['title' => 'Trader Info', 'icon' => '👤'],
            ['title' => 'Security', 'icon' => '🔒'],
            ['title' => 'Legal', 'icon' => '📜'],
            ['title' => 'Payments', 'icon' => '💳'],
            ['title' => 'Referrals', 'icon' => '🎁'],
            ['title' => 'Tech Support', 'icon' => '🛠️'],
        ];

        foreach ($categories as $data) {
            FaqCategory::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'icon' => $data['icon'],
            ]);
        }
    }
}
