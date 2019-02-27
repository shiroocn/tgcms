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
            //进行数据的检验
            $validate=$this->validate($postData,'app\admin\validate\Brand.show');
            if($validate!==true){
                //如果检检验不过关，提示错误。
                return json_shiroo('validate',$validate);
            }
            //获取POST过来的数据。
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
        /*//进行数据的检验
        $validate=$this->validate($postData,'app\admin\validate\Brand.add');
        if($validate!==true){
            //如果检检验不过关，提示错误。
            return json_shiroo('validate',$validate);
        }*/
        //取出POST过来的参数
        $brandName=$postData['brand_name'];
        $brandWeiXin=$postData['brand_weixin'];
        $brandWeiXinQRPath=$postData['brand_weixinqr_path'];
        $brandIconPath=$postData['brand_icon_path'];

        $data=[
            'brand_name'=>$brandName,
            'brand_weixin'=>$brandWeiXin,
            'brand_weixinqr_path'=>$brandWeiXinQRPath,
            'brand_icon_path'=>$brandIconPath
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
            $define=Db::name('brand_define_list')->where('bdl_brand_id',$brandID)->delete();
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0 && $define>=0){
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
            'brand_icon_path'=>$postData['brand_icon_path']
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
    public function define(){
        $postData=$this->request->param();
        if(IS_POST){
            $page = $postData['page'] - 1;
            $limit = $postData['limit'];
            try {
                $result = Db::name('brand_define')
                    ->limit($page * $limit, $limit)
                    ->order('bd_id', 'asc')
                    ->select();
                $count = Db::name('brand_define')->count('bd_id');
            } catch (\Exception $e) {
                return json_shiroo('database');
            }
            return json_shiroo(0, '', $count ?: 0, $result);

        }else{
            return $this->fetch();
        }
    }
    public function defineAdd(){
        $postData=$this->request->param();

        $data=[
            'bd_name'=>$postData['bd_name'],
            'bd_note'=>$postData['bd_note'],
            'bd_type'=>$postData['bd_type']
        ];
        try{
            $result=Db::name('brand_define')->insert($data);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('add.success');
        }else{
            return json_shiroo('add.error');
        }
    }
    public function defineEdit(){
        $postData=$this->request->param();

        $bdID=$postData['bd_id'];
        $data=[
            'bd_name'=>$postData['bd_name'],
            'bd_note'=>$postData['bd_note'],
        ];
        try{
            $result=Db::name('brand_define')->where('bd_id',$bdID)->update($data);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('edit.success');
        }else{
            return json_shiroo('edit.error');
        }
    }
    public function defineDel(){
        $postData=$this->request->param();
        $bdID=$postData['bd_id'];
        try{
            $result=Db::name('brand_define')->where('bd_id',$bdID)->delete();
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('del.success');
        }else{
            return json_shiroo('del.error');
        }
    }
    public function defineList(){
        $postData=$this->request->param();
        $brandID=$postData['brand_id'];
        if(IS_POST){
            $page = $postData['page'] - 1;
            $limit = $postData['limit'];
            try {
                $result = Db::name('brand_define_list')
                    ->leftJoin('brand', 'brand_id=bdl_brand_id')
                    ->leftJoin('brand_define', 'bd_id=bdl_define_id')
                    ->where('bdl_brand_id', $brandID)
                    ->limit($page * $limit, $limit)
                    ->order('bdl_id', 'asc')
                    ->select();
                $count = Db::name('brand_define_list')->where('bdl_brand_id', $brandID)->count('bdl_id');
            } catch (\Exception $e) {
                return json_shiroo('database');
            }
            return json_shiroo(0, '', $count ?: 0, $result);

        }else{
            //获取页面上新增与编辑的参数名称列表，供用户选择
            try{
                $defines=Db::name('brand_define')->select();
            }catch (\Exception $e){
                $defines=array();
            }

            $this->assign('defines',$defines);
            $this->assign('brand_id',$brandID);
            return $this->fetch();
        }
    }
    public function defineListAdd(){
        $postData=$this->request->param();

        $bdlDefineID=$postData['bdl_define_id'];
        $bdlDefineVar=$postData['bdl_define_var'];
        $bdlBrandID=$postData['bdl_brand_id'];
        $data=[
            'bdl_define_id'=>$bdlDefineID,
            'bdl_define_var'=>$bdlDefineVar,
            'bdl_brand_id'=>$bdlBrandID
        ];
        $where=[
            'bdl_define_id'=>$bdlDefineID,
            'bdl_brand_id'=>$bdlBrandID
        ];
        try{
            $exist=Db::name('brand_define_list')->where($where)->find();
            if(!is_null($exist)){
                return json_shiroo('exist');
            }
            $result=Db::name('brand_define_list')->insert($data);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('add.success');
        }else{
            return json_shiroo('add.error');
        }
    }
    public function defineListEdit(){
        $postData=$this->request->param();

        $bdlID=$postData['bdl_id'];
        $bdlBrandID=$postData['bdl_brand_id'];
        $data=[
            'bdl_define_var'=>$postData['bdl_define_var'],
        ];
        $where=[
            'bdl_id'=>$bdlID,
            'bdl_brand_id'=>$bdlBrandID
        ];
        try{
            $result=Db::name('brand_define_list')->where($where)->update($data);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('edit.success');
        }else{
            return json_shiroo('edit.error');
        }
    }
    public function defineListDel(){
        $postData=$this->request->param();
        $bdlID=$postData['bdl_id'];
        try{
            $result=Db::name('brand_define_list')->where('bdl_id',$bdlID)->delete();
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0){
            return json_shiroo('del.success');
        }else{
            return json_shiroo('del.error');
        }
    }

}