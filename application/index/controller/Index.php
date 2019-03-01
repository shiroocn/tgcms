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
            //首页查询访问落地页的域名是否已在后台绑定
            $domain=Db::name('domain')->where('domain_url',$domain)->find();
            if(is_null($domain) && !is_array($domain)){
                //查询结果没有绑定的话，返回错误提示
                return '域名：'.$domain.'没有绑定。';
            }
            //获取前一页的URL。用于判断是直接输入URL访问还是从搜索引擎点进来的
            $previousURL=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';

            //如果站点允许来源有值的话，表示设置了允许来源，为空表示不限制访问
            if(!empty($domain['page_source_allow'])){
                //设置了允许来源，进行限制访问
                try{
                    //设置的值格式为1,2,3  每个数字表示source_id
                    $sources=Db::name('source')->where('source_id','in',$domain['page_source_allow'])->select();
                    //上面按照ID进行查询
                }catch (\Exception $e){
                    $sources=[];
                }
                $allow=false;
                foreach ($sources as $source){
                    //判断来源的特征码是否存在于URL中。
                    $allow=strpos($previousURL,$source['source_feature']);
                    if($allow!==false){
                        //存在，表示允许来源访问，否则跳到默认页面
                        //跳出循环
                        break;
                    }
                }
                if($allow===false){
                    //不允许访问，跳转默认设置页面
                    $pageName='ex';
                }
            }

            //查询落地页，
            $where=['page_domain_id'=>$domain['domain_id'],'page_name'=>$pageName];
            $page=Db::name('page')
                ->join('domain','page_domain_id=domain_id')
                ->join('template','page_template_id=template_id')
                ->join('template_dir','template_dir_id=_template_dir_id')
                ->join('brand','page_brand_id=brand_id')
                ->where($where)
                ->find();
            //查询推广线索的扩展参数
            $defines=Db::name('brand_define_list')
                ->join('brand_define','bd_id=bdl_define_id')
                ->where('bdl_brand_id',$page['brand_id'])->select();

        }catch (\Exception $exception){
            return '查询数据库异常。';
           // Log::record('执行查询落地页数据库失败。'.$exception,'error');
        }
        if(is_null($page) && !is_array($page)){
            //访问的落地页不存在的话，返回错误
            return '【'.$pageName.'】页面不存在';
        }else{
            //落地页存在
            $def=[];//定义一个空的数组，用于储存循环读取到的扩展参数。
            if(is_array($defines)){
                //如果该推广线索存在设置了扩展参数。
                foreach ($defines as $define){
                    //循环读取设置的所有扩展参数，
                    $def['defines'][$define['bd_name']]=$define['bdl_define_var'];
                }
            }
            //把扩展参数合并到所有的参数里中去。
            $page=array_merge($page,$def);
            //dump($page);
            //输出所有参数到模板，使用$sh调用。
            $this->assign('sh',$page);
            //这里只是去掉了文件后缀.html，因为带后缀$this->fetch会出错。
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
