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
            $userName=$postData['user_name'];
            $userPassword=$postData['user_password'];
            if($userName=='a' && $userPassword=='a'){
                session('uid',1);
                return json_shiroo('login.success');
            }else{
                return json_shiroo('login.error');
            }
        }else{
            return $this->fetch();
        }
    }
    public function loginOut(){
           session('uid',null);
    }
}