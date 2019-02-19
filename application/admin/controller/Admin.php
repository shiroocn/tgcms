<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/1/24
 * Time: 9:33
 */

namespace app\admin\controller;


use think\Db;

class Admin extends Base
{
    public function login()
    {
        if (IS_POST) {
            $postData = $this->request->param();
            $userName = $postData['user_name'];
            $userPassword = $postData['user_password'];
            $where = [
                'user_account' => $userName,
                'user_password' => sha1($userPassword)
            ];
            try{
                $result = Db::name('user')
                    ->join('admin','admin_user_id=user_id')
                    ->where($where)->find();
            }catch (\Exception $e){
                $result=null;
            }
            if (is_array($result) && !is_null($result)) {
                //验证成功
                session('uid', $result['user_id']);
                return json_shiroo('login.success');
            } else {
                return json_shiroo('login.error');
            }
        } else {
            return $this->fetch();
        }
    }

    public function loginOut()
    {
        session('uid', null);
    }
}