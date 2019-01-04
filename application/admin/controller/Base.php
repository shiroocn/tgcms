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
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        define('IS_POST',$this->request->isPost()?:false);
        echo 'bbbbbbbbbbbb';

    }
    public function initialize(){
        echo 'aaaaaaaaaaaaaa';

    }

}