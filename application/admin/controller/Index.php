<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/9/3
 * Time: 20:36
 */

namespace app\admin\controller;

class Index extends Base
{
    public function index(){
        return 'welcome!';
    }

    public function login(){

        return $this->fetch();

    }
    public function loginOut(){
        return "退出成功";
    }

}