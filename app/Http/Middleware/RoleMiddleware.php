<?php

// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\AdminController;
  
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        //dd($user);
        if (!$user || !in_array($user->user_type, $roles)) {
            return response()->redirectToRoute('login');
        }

        return $next($request);
    }
}
