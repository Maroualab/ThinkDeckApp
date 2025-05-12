<?php

namespace App\Http\Middleware;

use App\Models\Workspace;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkspaceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $workspace = $request->route('workspace') ?? null;
        $user = auth()->user();

        if (!$workspace instanceof Workspace) {
            abort(404, 'Workspace not found.');
        }
        if ($user->id === $workspace->owner->id) {
            return $next($request);
        }

        $member = $workspace->users->find($user->id);

        if ($member && $member->pivot->is_allowed === 'allowed') {
            return $next($request);
        }

        // Otherwise, deny access
        abort(403, 'You do not have access to this workspace.');
    }


}
