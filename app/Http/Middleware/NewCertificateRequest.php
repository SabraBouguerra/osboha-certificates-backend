<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\BaseController;
use App\Models\UserBook;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NewCertificateRequest
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
        $user = $request->user('api');
        $status = UserBook::where("user_id",$user->id)->where('status','open')->count();


        if($status > 1){
            $response  = [
                'success' => false,
                'data' => 'Finish the current book first'
            ];
            return response()->json($response,400);
        }
        return $next($request);
    }
}
