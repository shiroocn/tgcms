<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/4/4
 * Time: 23:12
 */

namespace app\admin\controller;


use think\Db;

class Tongji extends Base
{
    public function show(){
        $startTime=date('Y-m-d 00:00:00');
        $endTime=date('Y-m-d 23:59:59');

        if(IS_POST){
            $postData=$this->request->param();
            $page=$postData['page']-1;
            $limit=$postData['limit'];
            try{
                $result=Db::name('tongji')
                    ->limit($page*$limit,$limit)
                    ->where('tj_create_time','>',$startTime)
                    ->where('tj_create_time','<',$endTime)
                    ->order('tj_create_time','desc')
                    ->select();
                $count=Db::name('tongji')
                    ->where('tj_create_time','>',$startTime)
                    ->where('tj_create_time','<',$endTime)
                    ->count('tj_id');
            }catch (\Exception $e){
                return json_shiroo('database');
            }
            return json_shiroo(0,'page:'.$page.',limit:'.$limit,$count,$result);
        }else{
            //今日的访客数
            $todayCount=Db::name('tongji')
                ->where('tj_create_time','>',$startTime)
                ->where('tj_create_time','<',$endTime)
                ->count();
            //今日转化数
            $zhCount=Db::name('tongji')
                ->where('tj_create_time','>',$startTime)
                ->where('tj_create_time','<',$endTime)
                ->where('tj_zhuanhua',1)
                ->count();
            //今日转化率
            $zhl=round($zhCount/$todayCount*100,2);
            $this->assign('todayCount',$todayCount);
            $this->assign('zhCount',$zhCount);
            $this->assign('zhl',$zhl);
            return $this->fetch();
        }
    }
}