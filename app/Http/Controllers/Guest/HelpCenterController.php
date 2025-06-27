<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\FaqCategory;
use App\Models\Faq;
use App\Http\Controllers\Controller;

class HelpCenterController extends Controller
{
    protected array $categories = [
        'getting-started' => 'Getting Started',
        'account-settings' => 'Account & Settings',
        'copy-trading' => 'Copy Trading',
        'trader-info' => 'Trader Info',
        'security' => 'Security',
        'legal' => 'Legal & Compliance',
        'payments' => 'Payments',
        'referrals' => 'Referral Program',
        'technical-support' => 'Technical Support',
    ];


    public function index()
    {
        $faqs = Faq::where('id', '!=', 0)->get();
        $questions = $faqs->pluck('question');
        $categories = FaqCategory::withCount('faqs')->get();
        $hardcodedData = [
            'getting-started' => ['short' => 'Start using Entrade.', 'long' => 'Learn how to set up your Entrade account and begin trading.', 'icon' => '🚀'],
            'account-settings' => ['short' => 'Manage your profile.', 'long' => 'Manage your personal info, preferences, and login credentials.', 'icon' => '⚙️'],
            'copy-trading' => ['short' => 'Copy top traders.', 'long' => 'Understand how copy trading works and how to follow top traders.', 'icon' => '📈'],
            'trader-info' => ['short' => 'For signal providers.', 'long' => 'Info for signal providers, leaderboards, and trader stats.', 'icon' => '👤'],
            'security' => ['short' => 'Your data is safe.', 'long' => 'Your data and funds are safe. Learn more about our security.', 'icon' => '🔒'],
            'legal' => ['short' => 'Terms & policies.', 'long' => 'Review our terms, disclaimers, and compliance policies.', 'icon' => '📜'],
            'payments' => ['short' => 'Deposits & withdrawals.', 'long' => 'Deposit, withdrawal, and transaction-related FAQs.', 'icon' => '💳'],
            'referrals' => ['short' => 'Earn by inviting.', 'long' => 'Invite friends and earn rewards with our referral system.', 'icon' => '🎁'],
            'technical-support' => ['short' => 'Fix issues fast.', 'long' => 'Having issues? Here is how to resolve technical problems.', 'icon' => '🛠️'],
        ];

        $categories->each(function ($category) use ($hardcodedData) {
            $category->description = $hardcodedData[$category->slug] ?? [
                'short' => '',
                'long' => '',
                'icon' => ''
            ];
        });

        return view("guests.faq.index", compact('faqs', 'categories', 'questions'));
    }


    public function show(string $category): View
    {
        if (!array_key_exists($category, $this->categories)) {
            abort(404);
        }

        $title = $this->categories[$category];

        // Demo FAQ list – you can replace this per category later
        $faqs = [
            ['q' => "What is $title?", 'a' => "This section explains what $title is and how it works."],
            ['q' => "How do I use $title?", 'a' => "Follow these steps to use $title effectively."],
            ['q' => "Who is eligible for $title?", 'a' => "Eligibility criteria for $title are outlined here."],
        ];

        return view("guests.help.$category", compact('title', 'faqs'));
    }

    public function category($slug)
    {
        $category = FaqCategory::where('slug', $slug)->with('faqs')->firstOrFail();
        $faqs = $category->faqs;
        $title = $category->title;
        return view("guests.help.{$slug}", compact('category', 'faqs', 'title'));
    }
}
