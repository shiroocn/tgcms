<?php
namespace app\index\controller;

use think\Db;

class Index extends Base
{

    public function index()
    {

        //获取访问的落地页别名
        $pageName=$this->request->param('p')?:'index';
        //获取当前的域名
        $domain=$this->request->domain();
        //去掉http://字符。
        $domain=str_replace('http://','',$domain);
        $domain=str_replace('https://','',$domain);

        try{
            $domain=Db::name('domain')->where('domain_url',$domain)->find();
            if(is_null($domain) && !is_array($domain)){
                return '域名：'.$domain.'没有绑定。';
            }
            $where=['page_domain_id'=>$domain['domain_id'],'page_name'=>$pageName];
            $page=Db::name('page')
                ->join('model','page_model_id=model_id')
                ->join('model_dir','model_dir_id=m_model_dir_id')
                ->join('brand','page_brand_id=brand_id')
                ->where($where)
                ->find();
        }catch (\Exception $exception){
            return '查询数据库异常。';
           // Log::record('执行查询落地页数据库失败。'.$exception,'error');
        }
        if(is_null($domain) && !is_array($domain)){
            return '当前访问的页面不存在！';
        }else{
            $this->assign('shiroo',$page);
            //这里只是去掉了文件后缀.html，因为带后缀会出错。
            $str=$page['model_name'];
            $pos=strripos($str,'.');
            $str=substr($str,0,$pos);
            return $this->fetch($page['model_dir_name'].'/'.$str);
        }
    }
    public function hello($name='aaa'){
        return 'hello'.$name;
    }
}
