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
        'page_name'=>'require',
        'domain_id'=>'require|number',
        'model_id'=>'require|number',
        'model_dir_id'=>'require|number',
        'brand_id'=>'require|number',
        'page_id'=>'require|number'
    ];
    protected $message=[
        'page_name.require'=>'落地页别名不能为空。',
        'domain_id.require'=>'请选择所属域名。',
        'domain_id.number'=>'域名ID必须为数字。',
        'model_id.require'=>'请选择使用的模板。',
        'model_id.number'=>'模板ID必须为数字。',
        'brand_id.require'=>'请选择关联的用户。',
        'brand_id.number'=>'用户ID必须为数字。'
    ];
    protected $scene=[
        'add'=>['page_name','domain_id','model_id','brand_id'],
        'edit'=>['page_id','page_name','model_id','brand_id'],
        'delete'=>['page_id']
    ];
}