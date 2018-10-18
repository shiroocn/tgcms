<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/10/18
 * Time: 14:07
 */
namespace app\admin\validate;


use think\Validate;

class Domain extends Validate
{
    protected $rule=[
        'domain'=>'require',
        'copyright'=>'require'
    ];
    protected $message=[
        'domain.require'=>'域名不能为空。',
        'copyright'=>'版权所有不能为空',
    ];

}