<?php


namespace app\admin\validate;


use think\Validate;

class Tongji extends Validate
{
    protected $rule=[
        'domain_url'=>['require','sUrl'=>'[a-z0-9\.:-]+'],
        'domain_id'=>'require|number',
        'page'=>'number',
        'limit'=>'number'
    ];
    /*protected $message=[
        'domain_url.require'=>'域名不能为空。',
        'domain_id.require'=>'域名ID不能为空。',
        'domain_id.number'=>'域名ID必须为数字。',
        'page.number'=>'页数参数必须为数字',
        'limit.number'=>''
    ];*/
    protected $scene=[
        'add'=>['domain_url'],
        'edit'=>['domain_id'],
        'delete'=>['domain_id'],
        'show'=>['page','limit']
    ];

}