<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/3/21
 * Time: 21:17
 */

namespace app\index\controller;


use app\admin\model\Tongji as TongjiModel;

class Tongji extends Base
{
    public function add(){
        //当访客复制微信号或点击复制按钮后。即转化
        $postData=$this->request->param();

        //return json_shiroo(0,'aaaa',0,$postData);

        $id=$postData['id'];//获取统计记录的ID。访客访问的时候会在t_tongji表里添加一条统计记录。
        $str=$postData['copy_str'];//访客复制的文本信息
        $type=$postData['type'];//事件类型：1为载入完成事件，2为转化事件
        $sEvent=$postData['s_event'];//转化事件行为，是复制还是点击。copy或event
        switch ($type){
            case 1:
                //落地页载入完成
                $data=[
                    'tj_load_done'=>1,
                ];
                break;
            case 2:
                //转化。访客复制微信号或点击按钮复制微信号
                $data=[
                    'tj_str'=>$str,
                    'tj_zhuanhua'=>1,
                    'tj_zh_time'=>date('Y-m-d H:i:s'),
                    'tj_event'=>$sEvent
                ];
                break;
            default:
                $data=[];
        }
        try{
            $tj=TongjiModel::get($id);
            if(!is_null($tj)){
                $tjDB=$tj->save($data);
            }else{
                $tjDB=0;
            }
            //$tjDB=Db::name('tongji')->where('tj_id',$id)->update($data);
        }catch (\Exception $exception){
            $tjDB=0;
        }
        if($tjDB>0){
            $code=0;
        }else{
            $code=100;
        }
        return json_shiroo($code,'',$tjDB,['type'=>$type,'id'=>$id,'copy_str'=>$str]);
    }
}