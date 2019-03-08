<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/10/18
 * Time: 10:18
 */

namespace app\admin\controller;


use think\Db;

class Domain extends Base
{
    public function add(){
        if(IS_POST){
            //接收用户提交过来的POST数据，这里为一个数组数据
            $postData=$this->request->param();
            //进行数据的检验
            $validate=$this->validate($postData,'app\admin\validate\Domain.add');
            if($validate!==true){
                //如果检检验不过关，提示错误。
                return json_shiroo('validate',$validate);
            }
            $domainURL=$postData['domain_url'];
            $domainCopyright=htmlentities($postData['domain_copyright']);
            $domainCountCode=htmlentities($postData['domain_count_code']);
            $domainSourceAllow=isset($postData['sources'])?implode(',',$postData['sources']):null;
            //添加进数据库。
            $data=[
                'domain_url'=>$domainURL,
                'domain_copyright'=>$domainCopyright,
                'domain_count_code'=>$domainCountCode,
                'domain_source_allow'=>$domainSourceAllow
            ];
            try{
                $result=Db::name('domain')->insert($data);
            }catch (\Exception $e){
                return json_shiroo('database','新增数据异常，请重试！');
            }
            if($result>0){
                return json_shiroo('add.success');
            }else{
                return json_shiroo('add.error');
            }
        }else{
            //没有提交数据，直接显示添加页面
            return $this->fetch();
        }
    }
    public function show(){
        if(IS_POST){
            $postData=$this->request->param();
            $page=$postData['page']-1;
            $limit=$postData['limit'];
            try{
                $result=Db::name('domain')
                    ->limit($page*$limit,$limit)
                    ->order('domain_id','asc')
                    ->select();
                $count=Db::name('domain')->count('domain_id');
            }catch (\Exception $e){
                return json_shiroo(10,'没有获取到数据，可能是出错了。',0,[]);
            }

            return json_shiroo(0,'page:'.$page.',limit:'.$limit,$count,$result);
        }else{
            //查询允许来源列表数据，
            try{
                $sources=Db::name('source')->select();//如果不存在返回的是空数组。
            }catch (\Exception $e){
                $sources=[];
            }
            $this->assign('sources',$sources);
            return $this->fetch();
        }
    }
    public function edit(){
        $postData=$this->request->param();
        //进行数据校验
        $validate=$this->validate($postData,'app\admin\validate\Domain.edit_post');
        if($validate!==true){
            return json_shiroo('validate',$validate);
        }
        $domainID=$postData['domain_id'];
        //$domainURL=$postData['domain_url'];
        $domainCopyright=htmlentities($postData['domain_copyright']);
        $domainCountCode=htmlentities($postData['domain_count_code']);
        $domainSourceAllow=isset($postData['sources'])?implode(',',$postData['sources']):null;
        try{
            $result=Db::name('domain')->where('domain_id',$domainID)
                ->update([
                    'domain_copyright'=>$domainCopyright,
                    'domain_count_code'=>$domainCountCode,
                    'domain_source_allow'=>$domainSourceAllow
                ]);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result){
            return json_shiroo('edit.success');
        }else{
            return json_shiroo('edit.error');
        }
    }
    public function del(){
        $postData=$this->request->param();
        //进行数据校验
        $validate=$this->validate($postData,'app\admin\validate\Domain.delete');
        if($validate!==true){
            return json_shiroo('validate',$validate);
        }
        $postID=$postData['domain_id'];
        try{
            $result=Db::name('domain')->where('domain_id',$postID)->delete();
            $page=Db::name('page')->where('page_domain_id',$postID)->delete();
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0 && $page>=0){
            return json_shiroo('del.success','',$result);
        }else{
            return json_shiroo('del.error');
        }
    }
}