<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Refresh
{
    /**
     * Return a value for the field.
     *
     * @param null                                                $rootValue   Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[]                                             $args        The arguments that were passed into the field.
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context     Arbitrary data that is shared between all fields of a single query.
     * @param \GraphQL\Type\Definition\ResolveInfo                $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     *
     * @return array
     * @throws \GraphQL\Error\Error
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): array
    {
        /** @var \App\Models\User $user */
        $user = \Auth::guard()->user();
        if (null === $user) {
            throw new Error('Invalid credentials.');
        }

        // Generate random token
        $user->api_token = \Str::random(80);
        $user->save();

        return $user->toArray();
    }
}
