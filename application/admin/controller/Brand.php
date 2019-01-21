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
    public function add(){
        $postData=$this->request->param();

        $data=[
            'brand_name'=>$postData['brand_name'],
            'brand_weixin'=>$postData['brand_weixin'],
            'brand_weixinqr_path'=>$postData['brand_weixinqr_path'],
            'brand_icon_path'=>$postData['brand_icon_path'],
            'brand_bdl_id'=>0
        ];
        try{
            $result=Db::name('brand')->insert($data);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('add.success');
        }else{
            return json_shiroo('add.error');
        }
    }
    public function del(){
        $postData=$this->request->param();
        $brandID=$postData['brand_id'];
        try{
            $result=Db::name('brand')->where('brand_id',$brandID)->delete();
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('del.success');
        }else{
            return json_shiroo('del.error');
        }

    }
    public function edit(){
        $postData=$this->request->param();

        $brandID=$postData['brand_id'];
        $data=[
            'brand_name'=>$postData['brand_name'],
            'brand_weixin'=>$postData['brand_weixin'],
            'brand_weixinqr_path'=>$postData['brand_weixinqr_path'],
            'brand_icon_path'=>$postData['brand_icon_path'],
            'brand_bdl_id'=>0
        ];
        try{
            $result=Db::name('brand')->where('brand_id',$brandID)->update($data);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('edit.success');
        }else{
            return json_shiroo('edit.error');
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
        $postData=$this->request->param();
        $brandID=$postData['brand_id'];
        if(IS_POST){
            $page = $postData['page'] - 1;
            $limit = $postData['limit'];
            try {
                $result = Db::name('brand_define_list')
                    ->join('brand', 'brand_bdl_id=bdl_id')
                    ->join('brand_define', 'bd_id=bdl_define_id')
                    ->where('bdl_brand_id', $brandID)
                    ->limit($page * $limit, $limit)
                    ->order('page_id', 'asc')
                    ->select();
                $count = Db::name('brand_define_list')->where('bdl_brand_id', $brandID)->count('bdl_id');
            } catch (\Exception $e) {
                return json_shiroo('database');
            }
            return json_shiroo(0, '', $count ?: 0, $result);

        }else{
            return $this->fetch();
        }
    }

}