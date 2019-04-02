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
                if($result['user_password']!=shaPass($userPassword)){
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
    public function editPass(){
        if(IS_POST){
            $postData=$this->request->param();
            //进行数据的检验
            $validate=$this->validate($postData,'app\admin\validate\Admin.editPass');
            if($validate!==true){
                //如果检检验不过关，提示错误。
                return json_shiroo('validate',$validate);
            }
            $userID=getUserID();
            $oldPass=shaPass($postData['old_password']);
            $newPass=shaPass($postData['new_password']);
            $newPass2=shaPass($postData['new_password2']);
            if($newPass!=$newPass2){
                return json_shiroo('edit.error','两次输入的新密码不一致');
            }
            if($oldPass==$newPass){
                return json_shiroo('edit.error','新密码不能与旧密码一样');
            }
            try{
                $user=Db::name('user')->where('user_id',$userID)->find();
            }catch (\Exception $exception){
                return json_shiroo('edit.error','账户不存在');
            }
            $userPassword=$user['user_password'];
            if($oldPass!=$userPassword){
                return json_shiroo('edit.error','输入的旧密码不正确');
            }else{
                try{
                    $result=Db::name('user')->where('user_id',$userID)->update([
                        'user_password'=>$newPass
                    ]);
                }catch (\Exception $exception){
                    return json_shiroo('edit.error','密码修改失败，请重试');
                }
                if($result>0){
                    return json_shiroo('edit.success','密码修改完成');
                }else{
                    return json_shiroo('edit.error','密码修改失败');
                }
            }
        }else{
            return $this->fetch();
        }
    }
}