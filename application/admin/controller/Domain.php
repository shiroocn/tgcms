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
                'domain_url'=>$postDate['domain'],
                'domain_copyright'=>htmlentities($postDate['copyright']),
                'domain_count_code'=>htmlentities($postDate['countcode'])
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
        try{
            $result=Db::name('domain')->select();
        }catch (\Exception $e){
            $this->error('读取数据异常。');
            return false;
        }
        $this->assign('domain',$result);
        return $this->fetch();
    }
    public function edit(){
        $postData=$this->request->param();

        //进行数据校验
        $result=$this->validate($postData,'app\admin\validate\Domain.edit');
        if($result!==true){
            $this->error($result);
            return false;
        }
        //查找相应的数据
        $postID=$postData['id'];



    }
    public function delete(){

    }
}