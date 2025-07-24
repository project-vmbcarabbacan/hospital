<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserLog;
use App\Domain\Enums\LogEnum;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $by = auth('sanctum')->user();
        $name = $by ? $by->name : 'System';
        if($user) {
            UserLog::create([
                'user_id' => $user->id,
                'type' => 'CREATED',
                'description' => add_log(LogEnum::USER_CREATED, ['name' => $user->name, 'user' => $name, 'date' => now()]),
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $changes = $user->getChanges();
        $original = $user->getOriginal();

        $by = auth('sanctum')->user();
        $name = $by ? $by->name : 'System';

        foreach ($changes as $key => $newValue) {
            if (in_array($key, ['updated_at', 'created_at'])) continue;

            $description = '';
            if ($key == 'password') {
                $description = add_log(LogEnum::USER_PASSWORD, ['user' => $name, 'date' => now()]);
            } else {
                $oldValue = $original[$key] ?? null;
                $description = add_log(LogEnum::USER_UPDATED, ['old' => $oldValue, 'new' => $newValue,  'user' => $name, 'date' => now()]);
            }

            if (!empty($description)) {
                UserLog::create([
                    'user_id' => $user->id,
                    'type' => 'UPDATED',
                    'description' => $description,
                ]);
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
