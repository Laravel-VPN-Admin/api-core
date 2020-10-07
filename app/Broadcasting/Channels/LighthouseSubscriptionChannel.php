<?php

namespace App\Broadcasting\Channels;

use App\User;
use Nuwave\Lighthouse\Subscriptions\Contracts\AuthorizesSubscriptions;

class LighthouseSubscriptionChannel extends Channel
{
    private AuthorizesSubscriptions $subscriptionAuthorizer;

    public function __construct(AuthorizesSubscriptions $subscriptionAuthorizer)
    {
        $this->subscriptionAuthorizer = $subscriptionAuthorizer;
    }

    public function join(User $user): bool
    {
        return $this->subscriptionAuthorizer->authorize(request());
    }
}