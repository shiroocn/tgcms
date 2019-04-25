<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/3/7
 * Time: 10:11
 */

namespace app\index\validate;

use think\Validate;

class Index extends Validate
{
    protected $rule=[
        'p'=>['require','alphaNum','min'=>1,'max'=>50],
        'source'=>['alphaNum']
    ];
    protected $message=[
        'p.require'=>'落地页名称不能为空。',
        'p.min'=>'落地页名称长度必须为1~50位。',
        'p.max'=>'账号长度必须为1~50位。',
        'p.alphaNum'=>'落地页名称只能是字母与数字。',
        'source.alphaNum'=>'source参数只能是字母与数字。'
    ];
    protected $scene=[
        'open'=>['p','source'],
    ];
}