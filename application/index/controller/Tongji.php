<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/3/21
 * Time: 21:17
 */

namespace app\index\controller;


use think\Db;
use think\Exception;

class Tongji extends Base
{
    public function add(){
        $postData=$this->request->param();

        return json_shiroo(0,'aaaa',0,$postData);

        $data=[
            'tj_keyword'=>'',
            'tj_copy_text'=>'',
            'tj_btn_text'=>'',
            'tj_domain'=>'',
            'tj_page_name'=>'',
            'tj_create_data'=>'',
            'tj_url'=>'',
            'tj_device'=>'',
            'tj_ip'=>$this->request->ip(),
            'tj_token'=>''
        ];

        $where=[
            'tj_mac'=>'',
            'tj_ip'=>''
        ];
        /*try{
            $tjDB=Db::name('tongji')->where($where)->find();
        }catch (\Exception $exception){

        }*/
    }
}