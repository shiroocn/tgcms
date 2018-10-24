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
        'domain_url'=>'require',
        'domain_copyright'=>'require',
        'domain_id'=>'require|number'
    ];
    protected $message=[
        'domain_url.require'=>'域名不能为空。',
        'domain_copyright.require'=>'版权所有不能为空',
        'domain_id.require'=>'域名ID不能为空。',
        'domain_id.number'=>'域名ID必须为数字。'
    ];
    protected $scene=[
        'add'=>['domain_url','domain_copyright'],
        'edit'=>['domain_id'],
        'edit_post'=>['domain_id','domain_url','domain_copyright'],
        'delete'=>['domain_id']
    ];

}