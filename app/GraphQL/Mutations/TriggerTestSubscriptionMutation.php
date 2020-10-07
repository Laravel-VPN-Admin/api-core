<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Execution\Utils\Subscription;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class TriggerTestSubscriptionMutation
{
    public function resolve($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('logCreated', rand());
        \Nuwave\Lighthouse\Execution\Utils\Subscription::broadcast('test', rand());
        Subscription::broadcast('test', $root, true);
        Subscription::broadcast('test', $root, false);
        return true;
    }
}