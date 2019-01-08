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

    }
}