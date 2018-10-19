<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/10/19
 * Time: 20:19
 */

namespace app\admin\validate;


use think\Validate;

class Page extends Validate
{
    protected $rule=[
        'alias'=>'require',
        'domain_id'=>'require|number',
        'model_id'=>'number',
        'user_id'=>'number',
        'page_id'=>'require|number'
    ];
    protected $message=[
        'alias.require'=>'落地页别名不能为空。',
        'domain_id.require'=>'请选择所属域名。',
        'domain_id.number'=>'域名ID必须为数字。',
        'model_id.require'=>'请选择使用的模板。',
        'model_id.number'=>'模板ID必须为数字。',
        'user_id.require'=>'请选择关联的用户。',
        'user_id.number'=>'用户ID必须为数字。'
    ];
    protected $scene=[
        'add'=>['alias','domain_id','model_id','user_id'],
        'edit'=>['page_id'],
        'delete'=>['page_id']
    ];
}