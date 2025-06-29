<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;
use App\Models\FaqCategory;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'title' => 'Getting Started',
                'slug' => 'getting-started',
                'icon' => '🚀',
                'faqs' => [
                    ['q' => 'How do I start copy trading on Entrade?', 'a' => 'Sign up, browse top traders, and subscribe to one.'],
                    ['q' => 'How do I create an Entrade account?', 'a' => 'Click “Register”, provide your details, and confirm your email.'],
                    ['q' => 'What is copy trading and how does it work?', 'a' => 'Copy trading lets you automatically replicate trades of top-performing traders.'],
                ],
            ],
            [
                'title' => 'Account & Settings',
                'slug' => 'account-settings',
                'icon' => '⚙️',
                'faqs' => [
                    ['q' => 'How do I change my email or password?', 'a' => 'Visit your account settings to update login credentials.'],
                    ['q' => 'Can I enable two-factor authentication?', 'a' => 'Yes, go to Security Settings to enable 2FA.'],
                ],
            ],
            [
                'title' => 'Copy Trading',
                'slug' => 'copy-trading',
                'icon' => '📈',
                'faqs' => [
                    ['q' => 'What are the risks of copy trading?', 'a' => 'Copy trading involves risk; always diversify and monitor.'],
                    ['q' => 'Can I stop copying a trader anytime?', 'a' => 'Yes, you can unsubscribe from a trader instantly.'],
                ],
            ],
            [
                'title' => 'Trader Info',
                'slug' => 'trader-info',
                'icon' => '👤',
                'faqs' => [
                    ['q' => 'How can I become a signal provider?', 'a' => 'Apply via the trader dashboard if you meet performance criteria.'],
                    ['q' => 'Where can I view my trading performance?', 'a' => 'Go to your performance tab in the dashboard.'],
                ],
            ],
            [
                'title' => 'Security',
                'slug' => 'security',
                'icon' => '🔒',
                'faqs' => [
                    ['q' => 'How secure is Entrade?', 'a' => 'We use encryption, firewalls, and 2FA to secure your account.'],
                    ['q' => 'What should I do if I suspect unauthorized access?', 'a' => 'Change your password immediately and contact support.'],
                ],
            ],
            [
                'title' => 'Legal',
                'slug' => 'legal',
                'icon' => '📜',
                'faqs' => [
                    ['q' => 'Where can I read the terms and disclaimers?', 'a' => 'They’re available on our Legal page.'],
                    ['q' => 'Is Entrade regulated?', 'a' => 'Entrade partners with licensed brokers; see our regulation page.'],
                ],
            ],
            [
                'title' => 'Payments',
                'slug' => 'payments',
                'icon' => '💳',
                'faqs' => [
                    ['q' => 'How do I deposit funds?', 'a' => 'Use crypto wallets or available gateways in your account.'],
                    ['q' => 'How do I withdraw my earnings?', 'a' => 'Go to the Wallet > Withdraw section to request.'],
                    ['q' => 'Are there any fees involved?', 'a' => 'Yes, minor network or withdrawal fees may apply.'],
                ],
            ],
            [
                'title' => 'Referrals',
                'slug' => 'referrals',
                'icon' => '🎁',
                'faqs' => [
                    ['q' => 'How does the referral program work?', 'a' => 'You earn rewards when users join and copy trade using your link.'],
                    ['q' => 'Where can I track my referral rewards?', 'a' => 'Go to the referral tab in your dashboard.'],
                ],
            ],
            [
                'title' => 'Tech Support',
                'slug' => 'tech-support',
                'icon' => '🛠️',
                'faqs' => [
                    ['q' => 'I’m having login issues, what should I do?', 'a' => 'Clear your cache, reset your password, or contact support.'],
                    ['q' => 'Why am I not receiving emails from Entrade?', 'a' => 'Check spam folder or whitelist our email domain.'],
                ],
            ],
        ];

        foreach ($data as $categoryData) {
            $category = FaqCategory::firstOrCreate(
                ['slug' => $categoryData['slug']],
                ['title' => $categoryData['title'], 'icon' => $categoryData['icon']]
            );

            foreach ($categoryData['faqs'] as $faq) {
                Faq::create([
                    'faq_category_id' => $category->id,
                    'question' => $faq['question'],
                    'answer'   => $faq['answer'],
                ]);
            }
        }
    }
}
