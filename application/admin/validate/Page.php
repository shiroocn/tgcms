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
    protected $rule = [
        'page_name' => 'require|alphaNum',
        'domain_id' => 'require|number',
        'template_id' => 'require|number',
        'brand_id' => 'require|number',
        'page_id' => 'require|number',
        'apply_all_template' => ['regex' => '/^(on|off)$/i'],
        'apply_all_brand' => ['regex' => '/^(on|off)$/i'],
        'page_name_prefix' => 'require|alpha',
        'page_name_suffix_min' => 'require|number',
        'page_name_suffix_max' => 'require|number',
        'template_dir_id'=>'require|number'
    ];
    protected $scene = [
        'add' => ['page_name', 'domain_id', 'template_id', 'brand_id'],
        'edit' => ['domain_id', 'page_id', 'template_id', 'brand_id', 'apply_all_template', 'apply_all_brand'],
        'delete' => ['page_id'],
        'batchAdd' => ['domain_id', 'page_name_prefix', 'page_name_suffix_min', 'page_name_suffix_max', 'template_id', 'brand_id'],
        'show'=>['domain_id'],
        'getTemplate'=>['template_dir_id']
    ];
}