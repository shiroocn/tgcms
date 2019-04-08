<?php
namespace app\index\controller;

use think\Db;
use think\facade\Cookie;

class Index extends Base
{

    public function index()
    {
        //获取访问的落地页别名
        $postData=$this->request->param();
        $postData['p']=!empty($postData['p'])?$postData['p']:'index';

        //进行数据的检验
        $validate=$this->validate($postData,'app\index\validate\Index.open');
        if($validate!==true){
            //如果检检验不过关，提示错误。
            return json_shiroo('validate',$validate);
        }
        $pageName=$postData['p'];
        //获取当前的域名
        $domain=$this->request->domain();
        //去掉http://字符。
        $domain=str_replace('http://','',$domain);
        $domain=str_replace('https://','',$domain);

        try{
            //首页查询访问落地页的域名是否已在后台绑定
            $domainDB=Db::name('domain')->where('domain_url',$domain)->find();
        }catch (\Exception $e){
            return $this->errorPage('查询域名数据异常');
        }
        if(is_null($domainDB) && !is_array($domainDB)){
            //查询结果没有绑定的话，返回错误提示
            return $this->errorPage('访问的域名没有绑定');
        }

        //获取前一页的URL。用于判断是直接输入URL访问还是从搜索引擎点进来的
        $previousURL=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        if(!empty($previousURL)){
            $host=parse_url($previousURL,PHP_URL_HOST);//获取域名部分
        }else{
            $host='';
        }
        //如果站点允许来源有值的话，表示设置了允许来源，为空表示不限制访问
        if(!empty($domainDB['domain_source_allow'])){
            //设置了允许来源，进行限制访问
            try{
                //设置的值格式为1,2,3  每个数字表示source_id
                $sources=Db::name('source')->where('source_id','in',$domainDB['domain_source_allow'])->select();
                //上面按照ID进行查询
            }catch (\Exception $e){
                $sources=[];
            }
            $allow=false;
            foreach ($sources as $source){
                //判断来源的特征码是否存在于URL中。
                $allow=strpos($host,$source['source_feature']);
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

        try{
            //查询落地页，
            $where=['page_domain_id'=>$domainDB['domain_id'],'page_name'=>$pageName];
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
            return $this->errorPage('查询页面数据异常');
           // Log::record('执行查询落地页数据库失败。'.$exception,'error');
        }
        if(is_null($page) && !is_array($page)){
            //访问的落地页不存在的话，返回错误
            return $this->errorPage('访问的页面不存在');
        }else{
            //落地页存在

            //访客记录(必须能正常访问该页面，才进行统计)
            $tongji=[
                'tj_source'=>isset($postData['source'])?urldecode($postData['source']):'',
                'tj_keyword'=>isset($postData['keyword'])?urldecode($postData['keyword']):'',
                'tj_plan'=>isset($postData['plan'])?urldecode($postData['plan']):'',
                'tj_unit'=>isset($postData['unit'])?urldecode($postData['unit']):'',
                'tj_domain'=>$domain,
                'tj_page_name'=>$pageName,
                'tj_create_time'=>date('Y-m-d H:i:s'),
                'tj_device'=>$this->request->isMobile()?'YD':'PC',
                'tj_ip'=>$this->request->ip()
            ];
            $tongjiID=$this->newVisitor($tongji);
            $this->assign('tongji_id',$tongjiID);

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
            //动态改变一下模板路径。
            $this->view->config('view_path',$_SERVER['DOCUMENT_ROOT'].'/public/static/template/');
            //输出相应的模板视图
            return $this->fetch($page['template_dir_name'].'/'.$str);
        }
    }
}
