<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Http\JsonResponse;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Login
{
    /**
     * Return a value for the field.
     *
     * @param null                                                $rootValue   Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[]                                             $args        The arguments that were passed into the field.
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context     Arbitrary data that is shared between all fields of a single query.
     * @param \GraphQL\Type\Definition\ResolveInfo                $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     *
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // Fetch User
        $user = User::query()
            ->where('email', $args['email'])
            ->first();

        // If user is not found
        if (!$user instanceof User) {
            return ['message' => 'User not found'];
        }

        // Verify the password
        if (password_verify($args['password'], $user->password)) {
            $user->api_token = \Str::random(80);
            $user->save();
            return ['token' => $user->api_token];
        }

        return ['message' => 'Invalid credentials'];
    }
}
