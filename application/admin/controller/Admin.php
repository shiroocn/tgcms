<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/1/24
 * Time: 9:33
 */

namespace app\admin\controller;


class Admin extends Base
{
    public function login(){
        if(IS_POST){
            $postData=$this->request->param();

            return json_shiroo('login.success','',0,$postData);

        }else{
            return $this->fetch();
        }
    }

}