<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/9/3
 * Time: 20:37
 */
namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    public function initialize(){
        define('IS_POST',$this->request->isPost()?:false);
        define('ACTION_NAME',$this->request->action()?:'');//全小写
        define('CONTROLLER_NAME',$this->request->controller()?:'');//实际一样
        define('UPLOADS_PATH','/uploads');
        //过滤不需要登陆的行为
        if(!in_array(ACTION_NAME,['login'])){
            //如果访问的action不在这个数组里面，则需要登录才能继续。
            if(!isLogin()){
                //没有登录的话是不允许访问，跳转登录页面
                $this->error('请先登录','admin/admin/login');
            }
        }else{
            if(isLogin()){
                $this->redirect('admin/index/index');
            }
        }
    }
}