<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
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
}
