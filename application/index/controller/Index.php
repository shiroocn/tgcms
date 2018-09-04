<?php
namespace app\index\controller;

use think\Db;
use think\facade\Log;

class Index extends Base
{
    public function index()
    {
        //动态改变模板路径
        $this->view->config('view_path','./static/template/');
        //获取访问的落地页ID
        $pageID=$this->request->param('p')?:0;
        //获取当前的域名
        $domain=$this->request->domain();
        //去掉http://字符。
        $domain=str_replace('http://','',$domain);
        $domain=str_replace('https://','',$domain);

        //这里知道是访问哪个域名。然后这里应该是读取这个域名的落地页列表
        //查询条件为域名与落地页ID
        $where=['domain_url'=>$domain,'page_id|page_alias'=>$pageID];
        try{
            $page=Db::name('page')
                ->join('domain','page_domain_id=domain_id')
                ->join('model','page_model_id=model_id')
                ->join('user','page_user_id=user_id')
                ->where($where)
                ->find();
        }catch (\Exception $exception){
            Log::record('执行查询落地页数据库失败。'.$exception,'error');
        }
        if(empty($page)){
            return '当前访问的页面不存在！';
        }else{
            //设置模板目录路径
            $templatePath='./static/template/'.$page['model_name'];

            //读取用户表里的自定义标签代码进行替换
            $tagCode=json_decode($page['user_tag_code'],true);//true的话返回数组array格式。

            //dump($page);
            //dump($tagCode);

            foreach ($tagCode as $key=>$value){
                //循环替换自定义标签。自动替换标签代码里的{$template_path}
                $value=str_replace('{$template_path}',$templatePath,$value);
                $this->assign($key,$value);
            }
            foreach ($page as $key=>$value){
                $this->assign($key,$value);
            }

            //这里替换模板里的{$template_path}路径。模板存放于public/static/template目录下，模板目录名称要与数据库里model_name一样。
            $this->assign('template_path',$templatePath);
            //PC模板路径
            $model_path_pc=$templatePath.'/'.$page['model_pc_filename'];
            //手机端模板路径
            $model_path_mobile=$templatePath.'/'.$page['model_mobile_filename'];

            if($this->request->isMobile()){
                if(file_exists($model_path_mobile)){
                    //存在手机端文件。
                    $model_path=$model_path_mobile;
                }else{
                    $model_path=$model_path_pc;
                }
            }else{
                $model_path=$model_path_pc;
            }
            return $this->fetch($model_path);
        }
    }
    public function hello($name='aaa'){
        return 'hello'.$name;
    }
}
