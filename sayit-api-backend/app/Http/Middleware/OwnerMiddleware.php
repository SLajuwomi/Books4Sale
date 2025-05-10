<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!ctype_digit($request->id)) {
            return response()->json(['error' => 'Invalid id.'], 400);
        }
        
        $sql = 'SELECT user_id FROM sayit_messages WHERE message_id=?';
        $result = DB::select($sql, [$request->id]);
        
        if (count($result) < 1) {
            return response()->json(['error' => 'No matching message found.'], 404);
        }
        
        if ($result[0]->user_id != $request->user()->id) {
            return response()->json(['error' => 'Unauthorized: You can only modify your own messages.'], 403);
        }

        return $next($request);
    }
}
