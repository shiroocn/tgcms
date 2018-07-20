<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/6/2
 * Time: 22:47
 */

namespace app\index\controller;

use think\App;
use think\Controller;

class Base extends Controller{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }
}