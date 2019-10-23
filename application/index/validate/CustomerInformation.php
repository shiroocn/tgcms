<?php


namespace app\index\validate;


use think\Validate;

class CustomerInformation extends Validate
{
    protected $rule=[
        'phone'=>['require','mobile'],
    ];
    protected $message=[
        'phone.require'=>'手机号不能为空',
        'phone.mobile'=>'手机号格式不正确'
    ];
    protected $scene=[
        'add'=>['phone'],
    ];

}