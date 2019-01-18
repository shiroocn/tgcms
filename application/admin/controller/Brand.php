<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/9/3
 * Time: 20:42
 */

namespace app\admin\controller;


use think\Db;

class Brand extends Base
{
    public function show(){
        if(IS_POST){
            $postData=$this->request->param();
            $page=$postData['page']-1;
            $limit=$postData['limit'];
            try{
                $result=Db::name('brand')
                    ->limit($page*$limit,$limit)
                    ->order('brand_id','asc')
                    ->select();
                $count=Db::name('brand')->count('brand_id');
            }catch (\Exception $e){
                return json_shiroo('database');
            }
            return json_shiroo(0,'page:'.$page.',limit:'.$limit,$count,$result);
        }else{
            return $this->fetch();
        }
    }
    public function addDefine(){
        if(IS_POST){
            $postData=$this->request->param();
            //进行数据校验

            $data=[
                'user_define_name'=>$postData['define_name'],
                'user_define_note'=>$postData['define_note']
            ];
            $result=Db::name('user_define')->insert($data);
            if($result){
                $this->success('添加成功。');
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
    }
    public function showDefine(){

    }

}