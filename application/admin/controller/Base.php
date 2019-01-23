<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/9/3
 * Time: 20:37
 */
namespace app\admin\controller;

use think\App;
use think\Controller;

class Base extends Controller
{
    public function initialize(){
        define('IS_POST',$this->request->isPost()?:false);
        define('ACTION',$action=$this->request->action()?:'');
        echo ACTION;


        //过滤不需要登陆的行为

        /*if (!in_array($action, array('login', 'vertify'))) {
            if (session('admin_id') > 0) {
                $this->check_priv();//检查管理员菜单操作权限
                $this->admin_id = session('admin_id');
            }else {
                (ACTION_NAME == 'index') && $this->redirect( U('Admin/Admin/login'));
                $this->error('请先登录', U('Admin/Admin/login'), null, 1);
            }
        }*/

    }

}