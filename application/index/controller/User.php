<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/7/19
 * Time: 16:56
 */

namespace app\index\controller;

use think\Db;

class User
{
    public function index(){
        $tag=array(
            'user_portrait'=>'{$template_path}/img/zjtx/bm.jpg',
            'user_banner1'=>'{$template_path}/img/zjtx/bm_banner_old.jpg',
            'user_banner2'=>'{$template_path}/img/zjtx/bm_banner_new.png',
            'user_wx_qr'=>'{$template_path}/img/zjtx/bm_qr.jpg'
        );
        $data=['user_tag_code'=>json_encode($tag)];
        $where=['user_id'=>1];
        Db::name('user')->where($where)->update($data);
        return '完成';
    }
    public function domain(){
        $code='<script id="kw_tongji" src="http://tj.shangdee.com/kw.js?sign=d6396e998eb50d46970e7b04340747f1" charset="UTF-8"></script>';
        $code=htmlentities($code);
        $data=['domain_count_code'=>$code];
        Db::name('domain')->whereBetween('domain_id','1,3')->update($data);
        return '完成';
    }

}