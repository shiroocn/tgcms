<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/2/19
 * Time: 17:00
 */

namespace app\admin\validate;


use think\Validate;

class Brand extends Validate
{
    protected $rule=[
        'page'=>['require','number'],
        'limit'=>['require','number'],
        'brand_name'=>['require'],
        'brand_weixin'=>['require'],
        'brand_weixinqr_path'=>[],
        'brand_icon_path'=>[]
    ];
    protected $message=[
        'page.number'=>'页数必须为数字。',
        'page.require'=>'页数不能为空。',
        'limit.require'=>'分页参数不能为空。',
        'limit.number'=>'分页参数必须为数字。'
    ];
    protected $scene=[
        'show'=>['page','limit'],
        'add'=>['brand_name','brand_weixin','brand_weixinqr_path','brand_icon_path']
    ];

}