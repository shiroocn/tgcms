<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/1/17
 * Time: 17:39
 */

namespace app\admin\controller;


use think\Db;

class Template extends Base
{
    public function show(){
        if(IS_POST){
            $postData=$this->request->param();
            $page=$postData['page']-1;
            $limit=$postData['limit'];
            try{
                $result=Db::name('template_dir')
                    ->limit($page*$limit,$limit)
                    ->order('template_dir_id','asc')
                    ->select();
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
            try {
                $brand = Db::name('brand')->select();
                $templateDir = Db::name('template_dir')->select();
            } catch (\Exception $e) {
                $this->error(err('database')['msg']);
            }
            $this->assign('brand', isset($brand) ? $brand : []);
            $this->assign('template_dir', isset($templateDir) ? $templateDir : []);
            $this->assign('template_dir_id', $templateDirID);
            return $this->fetch();
        }

    }

}