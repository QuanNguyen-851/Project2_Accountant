<?php

namespace App\Http\Middleware;

use App\Models\MinistryModel;
use Closure;
use Illuminate\Http\Request;

class CheckBlock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->session()->get('id');
        $check = MinistryModel::select('*')
        ->where('id',$id)->first();
        if($check->block == 0)
        {
            return $next($request);
        }
        else
        {
            $request->session()->flush();
            return redirect(route('login'))->with('error','Tài khoản đã bị khóa');
        }
    }
}
