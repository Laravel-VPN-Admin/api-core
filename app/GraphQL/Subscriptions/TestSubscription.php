<?php

namespace App\GraphQL\Subscriptions;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Http\Request;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Subscriptions\Subscriber;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class TestSubscription extends GraphQLSubscription
{
    /**
     * Check if subscriber is allowed to listen to the subscription.
     *
     * @param \Nuwave\Lighthouse\Subscriptions\Subscriber $subscriber
     * @param \Illuminate\Http\Request                    $request
     *
     * @return bool
     */
    public function authorize(Subscriber $subscriber, Request $request)
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
    public function filter(Subscriber $subscriber, $root)
    {
        return true;
    }

    public function resolve($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return $root;
    }
}