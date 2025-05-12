<?php

namespace App\Listeners;

use App\Models\Referral;
use App\Models\SiteSetting;
use App\Helpers\ReferralBonusHelper;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\DB;

class TriggerReferralBonus
{
    public function handle($event): void
    {
        $user = $event->user ?? null;

        if (!$user || !$user->referredBy) {
            return;
        }

        $referral = Referral::where('referred_id', $user->id)->first();

        if (!$referral || $referral->status !== 'pending') {
            return;
        }

        $triggered = false;

        if (
            $event instanceof \Illuminate\Auth\Events\Registered &&
            ReferralBonusHelper::isTriggerEnabled('referral_bonus_trigger_registration')
        ) {
            $triggered = true;
        }

        if (
            $event instanceof \App\Events\FirstDepositMade &&
            ReferralBonusHelper::isTriggerEnabled('referral_bonus_trigger_first_deposit')
        ) {
            $triggered = true;
        }

        if (
            $event instanceof \App\Events\DepositMade &&
            ReferralBonusHelper::isTriggerEnabled('referral_bonus_trigger_every_deposit')
        ) {
            $triggered = true;
        }

        if ($triggered) {
            DB::transaction(function () use ($referral) {
                $bonusType = SiteSetting::where('key', 'referral_bonus_type')->value('value') ?? 'fixed';
                $bonusAmount = SiteSetting::where('key', 'referral_bonus_amount')->value('value') ?? 10;

                $bonus = $bonusType === 'percentage'
                    ? $referral->referred->balance * ($bonusAmount / 100)
                    : $bonusAmount;

                $referral->update([
                    'status' => 'paid',
                    'bonus_amount' => $bonus,
                ]);

                $referral->referrer->increment('balance', $bonus);

                ActivityLogger::log('referral_bonus_auto_paid', 'Referral bonus automatically paid', $referral->referrer_id);
            });
        }
    }
}
