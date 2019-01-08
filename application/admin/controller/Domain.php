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
            $postDate=$this->request->param();

            //进行数据的检验
            $result=$this->validate($postDate,'app\admin\validate\Domain.add');
            if($result!==true){
                //如果检检验不过关，提示错误。
                return json_shiroo('validate');
            }
            //添加进数据库。
            $data=[
                'domain_url'=>$postDate['domain_url'],
                'domain_copyright'=>htmlentities($postDate['domain_copyright']),
                'domain_count_code'=>htmlentities($postDate['domain_count_code'])
            ];
            $result=Db::name('domain')->insert($data);
            if($result){
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
            return $this->fetch();
        }
    }
    public function edit(){
        if(IS_POST){
            $postData=$this->request->param();
            //进行数据校验
            $result=$this->validate($postData,'app\admin\validate\Domain.edit.post');
            if($result!==true){
                return json_shiroo('validate');
            }
            $domainID=$postData['domain_id'];
            //$domainURL=$postData['domain_url'];
            $domainCopyright=htmlentities($postData['domain_copyright']);
            $domainCountCode=htmlentities($postData['domain_count_code']);
            try{
                $result=Db::name('domain')->where('domain_id',$domainID)
                    ->update([
                        'domain_copyright'=>$domainCopyright,
                        'domain_count_code'=>$domainCountCode
                    ]);
            }catch (\Exception $e){
                return json_shiroo('database');
            }
            if($result){
                return json_shiroo('edit.success');
            }else{
                return json_shiroo('edit.error');
            }
        }else{
            $postData=$this->request->param();

            //进行数据校验
            $result=$this->validate($postData,'app\admin\validate\Domain.edit');
            if($result!==true){
                $this->error($result);
                return false;
            }
            //查找相应的数据
            $postID=$postData['domain_id'];
            //查询该ID的数据
            try{
                $result=Db::name('domain')->where('domain_id',$postID)->find();
            }catch (\Exception $e){
                $this->error(err('database.msg'));
            }
            $this->assign('result',$result);
            return $this->fetch();
        }
    }
    public function del(){
        return json_shiroo('del.success');
        $postData=$this->request->param();
        //进行数据校验
        $result=$this->validate($postData,'app\admin\validate\Domain.delete');
        if($result!==true){
            return json_shiroo('validate');
        }
        $postID=$postData['domain_id'];
        try{
            $result=Db::name('domain')->where('domain_id',$postID)->delete();
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result){
            return json_shiroo('del.success',$result);
        }else{
            return json_shiroo('del.error');
        }
    }
}