<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
function json_shiroo($code,$msg='',$count=0,$data=array()){
    if($code!=0){
        $arr=[
            'code'=>config($code.'.code'),
            'msg'=>config($code.'.msg'),
            'count'=>0];
    }else{
        $arr=['code'=>$code,'msg'=>$msg,'count'=>$count];
    }
    return json(array_merge($arr,array('data'=>$data)));
}
function err($name){
    $n=explode('.',$name);
    $err=[
        'edit' => [
            'code' => 10,
            'msg' => ''
        ],
        'del' => [

        ],
        'add' => [

        ],
        'validate' => [
            'code' => 14,
            'msg' => '非法数据，请重试。'
        ]
    ];

    return $err[$n[0]][$n[1]];

    if (is_string($name)) {
        if ('.' == substr($name, -1)) {
            return Config::pull(substr($name, 0, -1));
        }

        return 0 === strpos($name, '?') ? Config::has(substr($name, 1)) : Config::get($name);
    } else {
        return Config::set($name, $value);
    }


}

