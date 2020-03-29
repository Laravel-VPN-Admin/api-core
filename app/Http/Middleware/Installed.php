<?php


namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class Installed
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected array $except = [
        '/install'
    ];

    public const INSTALLATION_ROUTES = [
        'InstallerController::welcome',
        'InstallerController::requirements',
        'InstallerController::database',
        'InstallerController::administrator',
        'InstallerController::finish',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $filename = storage_path('installed');
        if (file_exists($filename)) {
            return $next($request);
        }

        $route = \Route::getRoutes()->match($request)->getName();
        if (in_array($route, self::INSTALLATION_ROUTES, true)) {
            return $next($request);
        }

        return redirect()->route('InstallerController::welcome');
    }
}