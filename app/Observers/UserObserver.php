<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\User $user
     *
     * @return void
     */
    public function created(User $user)
    {
        $user->api_token = \Hash::make(\Str::random(80));
        $user->save();
    }

}
