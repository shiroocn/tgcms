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
            //进行数据的检验
            $validate=$this->validate($postData,'app\admin\validate\Admin.login');
            if($validate!==true){
                //如果检检验不过关，提示错误。
                return json_shiroo('validate',$validate);
            }
            $userName = $postData['user_name'];
            $userPassword = $postData['user_password'];
            $where = [
                'user_account' => $userName,
            ];
            try{
                $result = Db::name('user')
                    ->leftJoin('admin','admin_user_id=user_id')
                    ->where($where)->find();
            }catch (\Exception $e){
                return json_shiroo('database','登录出现异常，请重试。');
            }

            if (is_array($result) && !is_null($result)) {
                //存在记录
                if($result['user_password']!=sha1($userPassword)){
                    return json_shiroo('login.error','登录密码不正确。');
                }else{
                    if($result['admin_id']>0){
                        session('user',$result);
                        return json_shiroo('login.success');
                    }else{
                        return json_shiroo('login.error','该账号非管理员账号。');
                    }
                }
            } else {
                return json_shiroo('login.error','账号不存在，请重新输入。');
            }
        } else {
            return $this->fetch();
        }
    }

    public function loginOut()
    {
        session('user', null);
        $this->redirect('admin/admin/login');
    }
}