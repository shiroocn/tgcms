<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/2/19
 * Time: 15:50
 */

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule=[
        'user_name'=>['require','min'=>3,'max'=>20],
        'user_password'=>['require','min'=>6,'max'=>20]
    ];
    protected $message=[
        'user_name.require'=>'账号不能为空。',
        'user_name.min'=>'账号长度必须为3~20位。',
        'user_name.max'=>'账号长度必须为3~20位。',
        'user_password.require'=>'密码不能为空。',
        'user_password.min'=>'密码长度必须为6~20位。',
        'user_password.max'=>'密码长度必须为6~20位。'
    ];
    protected $scene=[
        'login'=>['user_name','user_password'],
    ];

}