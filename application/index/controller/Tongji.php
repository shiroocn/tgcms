<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/3/21
 * Time: 21:17
 */

namespace app\index\controller;


use think\Db;

class Tongji extends Base
{
    public function add(){
        $postData=$this->request->param();

        //return json_shiroo(0,'aaaa',0,$postData);

        $id=$postData['id'];
        $str=$postData['copy_str'];
        $data=[
            'tj_str'=>$str,
            'tj_zhuanhua'=>1,
            'tj_zh_time'=>date('Y-m-d H:i:s')
        ];
        try{
            $tjDB=Db::name('tongji')->where('tj_id',$id)->update($data);
        }catch (\Exception $exception){

        }
    }
}