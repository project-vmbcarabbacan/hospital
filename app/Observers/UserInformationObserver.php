<?php

namespace App\Observers;

use App\Models\UserInformation;
use App\Models\UserLog;
use App\Domain\Enums\LogEnum;

class UserInformationObserver
{
    /**
     * Handle the UserInformation "created" event.
     */
    public function created(UserInformation $userInformation): void
    {
        //
    }

    /**
     * Handle the UserInformation "updated" event.
     */
    public function updated(UserInformation $userInformation): void
    {
        $changes = $userInformation->getChanges();
        $original = $userInformation->getOriginal();

        $by = auth('sanctum')->user();
        $name = $by ? $by->name : 'System';

        foreach ($changes as $key => $newValue) {
            if (in_array($key, ['updated_at', 'created_at'])) continue;

            $oldValue = $original[$key] ?? null;
            $description = add_log(LogEnum::USER_UPDATED, ['old' => $oldValue, 'new' => $newValue,  'user' => $name, 'date' => now()]);

            if (!empty($description)) {
                UserLog::create([
                    'user_id' => $userInformation->user_id,
                    'type' => 'UPDATED',
                    'description' => $description,
                ]);
            }
        }
    }

    /**
     * Handle the UserInformation "deleted" event.
     */
    public function deleted(UserInformation $userInformation): void
    {
        //
    }

    /**
     * Handle the UserInformation "restored" event.
     */
    public function restored(UserInformation $userInformation): void
    {
        //
    }

    /**
     * Handle the UserInformation "force deleted" event.
     */
    public function forceDeleted(UserInformation $userInformation): void
    {
        //
    }
}
