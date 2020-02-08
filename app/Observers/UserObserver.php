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
        $user->api_token = \Str::random(60);
        $user->save();
    }

}
