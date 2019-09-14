<?php

namespace App\Http\Middleware;

use Closure;

//引入需要的门面,Route获取路由
use Route;

//获取当前用户的信息
use Auth;
class CheckRbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('admin')->user()->role_id != '1'){
            //RBAC鉴权
            //获取当前的路由 App\Http\Controllers\Admin\IndexController@index
            $route = Route::currentRouteAction();
            //获取当前角色已经具备的权限
            $ac = Auth::guard('admin')->user() -> role ->auth_ac;
            $ac = strtolower($ac . 'IndexController@index,indexcontroller@welcome');
            //判断权限
            $routeArr = explode('\\',$route);
            //end获取数组的最后一个元素
            if(strpos($ac,strtolower(end($routeArr))) === false){
                exit('<h1>您没有访问权限</h1>');
            }
        }

        return $next($request);
    }
}
