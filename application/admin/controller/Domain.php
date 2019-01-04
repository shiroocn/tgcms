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
                $this->error($result);
                return false;
            }
            //添加进数据库。
            $data=[
                'domain_url'=>$postDate['domain_url'],
                'domain_copyright'=>htmlentities($postDate['domain_copyright']),
                'domain_count_code'=>htmlentities($postDate['domain_count_code'])
            ];
            $result=Db::name('domain')->insert($data);
            if($result){
                $this->success('添加成功。');
            }else{
                $this->error('添加失败。');
            }
            return false;
        }else{
            //没有提交数据，直接显示添加页面
            return $this->fetch();
        }
    }
    public function show(){
        if(IS_POST){
            try{
                $result=Db::name('domain')->select();
            }catch (\Exception $e){
                json();
                $this->error('读取数据异常,请重试。');
                return false;
            }
            //$this->assign('domain',$result);
            $arr=['code'=>0,'msg'=>'','count'=>count($result)];
            return json(array_merge($arr,array('data'=>$result)),0);
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
                $this->error($result);
                return false;
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
                $this->error('修改数据异常，请重试。');
                return false;
            }
            if($result){
                $this->success('修改成功。','admin/domain/show');
                return true;
            }else{
                $this->error('修改失败。');
                return false;
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
                $this->error('读取数据异常，请重试。');
            }
            $this->assign('result',$result);
            return $this->fetch();
        }
    }
    public function delete(){
        $postData=$this->request->param();
        //进行数据校验
        $result=$this->validate($postData,'app\admin\validate\Domain.delete');
        if($result!==true){
            $this->error($result);
            return false;
        }
        $postID=$postData['domain_id'];
        try{
            $result=Db::name('domain')->where('domain_id',$postID)->delete();
        }catch (\Exception $e){
            $this->error('删除数据异常，请重试。');
        }

        if($result){
            $this->success('删除成功。');
            return true;
        }else{
            $this->error('删除失败。');
            return false;
        }
    }
}