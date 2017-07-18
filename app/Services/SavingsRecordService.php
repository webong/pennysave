<?php

namespace App\Services;

class SavingsRecordService {

    public function total_currently_saved($savingsPlanId)
    {
        return Self::where('savings_plan_id', $savingsPlanId)
            ->where('user_id', Auth::user()->id)
            ->sum();
    }
}
