<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/6/2
 * Time: 22:47
 */

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\facade\Cookie;

class Base extends Controller{
    public function initialize()
    {

    }
    public function errorPage($title='',$content=''){
        return $this->fetch('public/error',['title'=>$title,'content'=>$content]);
    }
    protected function newVisitor($data){
        //先计算今日还余下多少秒
        $lastSeconds=strtotime(date('Y-m-d 23:59:59'));//获取当天最后一秒时间戳
        $nowSeconds=time();//获取当前的时间戳
        $remaining=$lastSeconds-$nowSeconds;//今日还余下的时间戳(秒)
        $token=sha1(md5($nowSeconds).'shiroo.cn');
        if(!Cookie::has('token','tongji_')){
            //如果不存在，表示新访客
            Cookie::set('token',$token,['prefix'=>'tongji_','expire'=>$remaining]);
        }else{
            $token=!empty(Cookie::get('token','tongji_'))?Cookie::get('token','tongji_'):$token;
        }
        //Cookie::set('time',$data['tj_create_time'],['prefix'=>'tongji_','expire'=>$remaining]);
        $data['tj_token']=$token;
        //$data的数据即为表的数据
        return Db::name('tongji')->insertGetId($data)?:0;
    }
}