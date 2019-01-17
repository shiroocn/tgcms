<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/1/17
 * Time: 17:39
 */

namespace app\admin\controller;


class Template extends Base
{
    public function show(){
        return $this->fetch();

    }

}