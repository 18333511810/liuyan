<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Role;
class AdminLogin
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
        //添加验证是否登录的代码；
        if(!Auth::guard('admin')->check()){
            //未登录
            return redirect('admin/login');
        }
        //验证当前是否有权限操作

       //获取当前的控制器名称
        $controller_name = getController_name();
       //获取当前的方法名称
        $action_name = getAction_name();
        //拼接当前操作的控制器和方法；
        $current_ac = $controller_name.'-'.$action_name;
        //取出当前管理员拥有的权限；
        $info = Auth::guard('admin')->user();
        if($info->id!=1){
            if($controller_name!='Index' && $controller_name!='Manager'){
                $has_ac = Role::where('id',$info->role_id)->value('priv_ac');
                if(strpos($has_ac,$current_ac)===false){
                    exit('你无权访问');
                }
            }
            
        }
        return $next($request);
    }
}
