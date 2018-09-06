<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/9/4
 * Time: 10:16
 */

namespace app\admin\controller;


use think\Db;

class Page extends Base
{
    public function index(){

    }
    public function add(){
        if(IS_POST){
            $alias=$this->request->param('alias');
            $modelID=$this->request->param('modelid');
            $domainID=$this->request->param('domainid');
            $userID=$this->request->param('userid');

            $data=[
                'page_alias'=>$alias,
                'page_model_id'=>$modelID,
                'page_domain_id'=>$domainID,
                'page_user_id'=>$userID
            ];
            $row=Db::name('page')->insert($data);
            if($row){
                //成功
                return '添加成功';
            }else{
                //失败
                return '添加失败';
            }
        }else{
            try{
                $dataDomain=Db::name('domain')->select();
                $dataModel=Db::name('model')->select();
                $dataUser=Db::name('user')->select();
            }catch (\Exception $e){
                return '读取数据出现异常，请重新刷新页面。';
            }
            $this->assign('dataDomain',$dataDomain);
            $this->assign('dataModel',$dataModel);
            $this->assign('dataUser',$dataUser);
            return $this->fetch();
        }
    }
    public function batchAdd(){

    }
    public function del(){

    }
    public function edit(){

    }
    public function show(){
        try{
            $pageDB=Db::name('page')
                ->join('domain','page_domain_id=domain_id')
                ->join('model','page_model_id=model_id')
                ->join('user','page_user_id=user_id')
                ->select();
        }catch (\Exception $e){

        }
        //dump($pageDB);
        $this->assign('pageData',$pageDB);
        return $this->fetch();
    }
}