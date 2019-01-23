<?php
namespace app\index\controller;

use think\Db;

class Index extends Base
{

    public function index()
    {

        //获取访问的落地页别名
        $pageName=$this->request->param('p');
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
                ->join('domain','page_domain_id=domain_id')
                ->join('template','page_template_id=template_id')
                ->join('template_dir','template_dir_id=_template_dir_id')
                ->join('brand','page_brand_id=brand_id')
                ->where($where)
                ->find();
            //自定义参数查询
            $defines=Db::name('brand_define_list')
                ->join('brand_define','bd_id=bdl_define_id')
                ->where('bdl_brand_id',$page['brand_id'])->select();

        }catch (\Exception $exception){
            return '查询数据库异常。';
           // Log::record('执行查询落地页数据库失败。'.$exception,'error');
        }
        if(is_null($page) && !is_array($page)){
            return '【'.$pageName.'】着陆页不存在';
        }else{
            $def=[];
            if(is_array($defines)){
                foreach ($defines as $define){
                    $def['defines'][$define['bd_name']]=$define['bdl_define_var'];
                }
            }
            $page=array_merge($page,$def);
            //dump($page);
            $this->assign('sh',$page);
            //这里只是去掉了文件后缀.html，因为带后缀会出错。
            $str=$page['template_name'];
            $pos=strripos($str,'.');
            $str=substr($str,0,$pos);
            return $this->fetch($page['template_dir_name'].'/'.$str);
        }
    }
    public function hello($name='aaa'){
        return 'hello'.$name;
    }
}
