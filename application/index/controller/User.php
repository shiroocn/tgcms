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
            'portrait'=>'{$template_path}/img/zjtx/bm.jpg',
            'banner1'=>'{$template_path}/img/zjtx/bm_banner_old.jpg',
            'banner2'=>'{$template_path}/img/zjtx/bm_banner_new.png',
            'wx_qr'=>'{$template_path}/img/zjtx/bm_qr.jpg'
        );
        $data=['user_tag_code'=>json_encode($tag)];
        $where=['user_id'=>1];
        Db::name('user')->where($where)->update($data);
        return '完成';
    }

}