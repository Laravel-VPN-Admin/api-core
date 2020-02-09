<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->token === null) {
            return $next($request);
        }

        $user = User::query()->where('api_token', $request->token)->first();
        if ($user instanceof User) {
            Auth::login($user);
        }
        return $next($request);

//        if (
//            $request->header('x-api-token')
//            && $request->header('x-app-id')
//            && $request->header('x-app-key')
//        ) {
//            $application = Application::query()
//                ->where('id', $request->header('x-app-id'))
//                ->where('key', $request->header('x-app-key'))
//                ->where('status', Application::STATUS_ACTIVE)
//                ->first();
//
//            if (null !== $application) {
//                $userToken = UserToken::query()
//                    ->where('token', $request->header('x-api-token'))
//                    ->where('application_id', $application->id)
//                    ->where('status', Application::STATUS_ACTIVE)
//                    ->first();
//
//                if (null !== $userToken && $userToken->isExpired() === false) {
//                    $request->route()->setParameter('user', $userToken->user);
//                    $request->route()->setParameter('application', $application);
//                    $request->route()->setParameter('user_token', $userToken);
//                    return $next($request);
//                }
//            }
//
//            return response()->json(['message' => 'Invalid application ID or Key'], 401);
//        }
//        return response()->json(['message' => 'Not a valid API request'], 400);
    }
}
