<?php

namespace App\GraphQL\Subscriptions;

use App\Models\Log;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Subscriptions\Subscriber;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LogCreated extends GraphQLSubscription
{
  /**
   * Check if subscriber is allowed to listen to the subscription.
   *
   * @param \Nuwave\Lighthouse\Subscriptions\Subscriber $subscriber
   * @param \Illuminate\Http\Request                    $request
   *
   * @return bool
   */
  public function authorize(Subscriber $subscriber, Request $request): bool
  {
    return true;
  }

  /**
   * Filter which subscribers should receive the subscription.
   *
   * @param \Nuwave\Lighthouse\Subscriptions\Subscriber $subscriber
   * @param mixed                                       $root
   *
   * @return bool
   */
  public function filter(Subscriber $subscriber, $root): bool
  {
    // Broadcast the subscription to the same
    // person who updated the post.
    return false;
  }
}
