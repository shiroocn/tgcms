<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/1/17
 * Time: 17:39
 */

namespace app\admin\controller;


use think\Db;
use app\admin\model\Template as TemplateModel;

class Template extends Base
{
    public function show(){
        if(IS_POST){
            $postData=$this->request->param();
            $page=$postData['page']-1;
            $limit=$postData['limit'];
            try{
                $result=TemplateModel::limit($page*$limit,$limit)->order('template_create_time','DESC')->select();
                /*$result=Db::name('template_dir')
                    ->limit($page*$limit,$limit)
                    ->order('template_dir_id','asc')
                    ->select();*/
                $count=Db::name('template_dir')->count('template_dir_id');
            }catch (\Exception $e){
                return json_shiroo('database');
            }


            return json_shiroo(0,'page:'.$page.',limit:'.$limit,$count,$result);
        }else{
            return $this->fetch();
        }
    }
    public function style(){

        $postData = $this->request->param();
        //检验数据有效性
        $templateDirID = $postData['template_dir_id'];

        if (IS_POST) {
            $page = $postData['page'] - 1;
            $limit = $postData['limit'];
            try {
                $result = Db::name('template')
                    ->join('template_dir', 'template_dir_id=_template_dir_id')
                    ->where('_template_dir_id', $templateDirID)
                    ->limit($page * $limit, $limit)
                    ->order('template_id', 'asc')
                    ->select();
                $count = Db::name('template')->where('_template_dir_id', $templateDirID)->count('template_id');
            } catch (\Exception $e) {
                return json_shiroo('database');
            }
            return json_shiroo(0, '', $count ?: 0, $result);
        } else {
            $this->assign('template_dir_id', $templateDirID);
            return $this->fetch();
        }

    }
    public function add(){
        $postData=$this->request->param();

        $templateDirName=$postData['template_dir_name'];
        $templateDirNote=$postData['template_dir_note'];
        $data=[
            'template_dir_name'=>$templateDirName,
            'template_dir_note'=>$templateDirNote
        ];
        $result=Db::name('template_dir')->insert($data);
        if($result>0){
            return json_shiroo('add.success');
        }else{
            return json_shiroo('add.error');
        }
    }
    public function addStyle(){
        $postData=$this->request->param();

        $templateName=$postData['template_name'];
        $templateDirID=$postData['template_dir_id'];
        $templateNote=$postData['template_note'];
        $data=[
            'template_name'=>$templateName,
            '_template_dir_id'=>$templateDirID,
            'template_note'=>$templateNote,
        ];
        $result=Db::name('template')->insert($data);
        if($result>0){
            return json_shiroo('add.success');
        }else{
            return json_shiroo('add.error');
        }

    }
    public function edit(){
        $postData=$this->request->param();

        $templateDirID=$postData['template_dir_id'];
        $templateDirName=$postData['template_dir_name'];
        $templateDirNote=$postData['template_dir_note'];
        $data=[
            'template_dir_name'=>$templateDirName,
            'template_dir_note'=>$templateDirNote
        ];
        try{
            $result=Db::name('template_dir')
                ->where('template_dir_id',$templateDirID)->update($data);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>=0){
            return json_shiroo('edit.success');
        }else{
            return json_shiroo('edit.error');
        }
    }
    public function editStyle(){
        $postData=$this->request->param();

        $templateID=$postData['template_id'];
        $templateName=$postData['template_name'];
        $templateNote=$postData['template_note'];
        $data=[
            'template_name'=>$templateName,
            'template_note'=>$templateNote
        ];
        try{
            $result=Db::name('template')
                ->where('template_id',$templateID)->update($data);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>=0){
            return json_shiroo('edit.success');
        }else{
            return json_shiroo('edit.error');
        }
    }
    public function del(){
        $postData=$this->request->param();

        $templateDirID=$postData['template_dir_id'];
        try{
            $result=Db::name('template_dir')
                ->where('template_dir_id',$templateDirID)->delete();
            $template=Db::name('template')->where('_template_dir_id',$templateDirID)->delete();

        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0 && $template>=0){
            return json_shiroo('del.success');
        }else{
            return json_shiroo('del.error');
        }
    }
    public function delStyle(){
        $postData=$this->request->param();

        $templateID=$postData['template_id'];
        try{
            $result=Db::name('template')
                ->where('template_id',$templateID)->delete();
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>=0){
            return json_shiroo('del.success');
        }else{
            return json_shiroo('del.error');
        }
    }

}