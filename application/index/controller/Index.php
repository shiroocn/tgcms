<?php

namespace app\index\controller;

use think\Db;
use think\facade\Cookie;
use app\admin\model\Tongji;

class Index extends Base
{

    public function index()
    {
        //获取访问的落地页别名
        $postData = $this->request->param();
        //如果p参数为空的话，默认为index
        $postData['p'] = !empty($postData['p']) ? $postData['p'] : 'index';

        //进行数据的检验,只允许字母与数字组合。
        $validate = $this->validate($postData, 'app\index\validate\Index.open');
        if ($validate !== true) {
            //如果检检验不过关，提示错误。
            return $this->errorPage('非法落地页名称');
            //return json_shiroo('validate', $validate);
        }

        $pageName = $postData['p'];//获取落地页名
        $source = isset($postData['source'])?urldecode($postData['source']):'';//渠道
        $plan = isset($postData['plan'])?urldecode($postData['plan']):'';//计划
        $unit = isset($postData['unit'])?urldecode($postData['unit']):'';//单元
        $keyword = isset($postData['keyword'])?urldecode($postData['keyword']):'';//关键词

        $domain_http = $this->request->domain();//获取当前的域名,带http://

        //去掉域名里的http://字符。
        $domain = str_replace('http://', '', $domain_http);
        $domain = str_replace('https://', '', $domain);

        //获取前一页的URL。用于判断是直接输入URL访问还是从搜索引擎点进来的
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        //从上一个跳转URL的参数里获取搜索词
        $searchKeyword = $this->getSearchKeyword($referer);

        try {
            //首页查询访问落地页的域名是否已在后台绑定
            $domainDB = Db::name('domain')->where('domain_url', $domain)->find();
        } catch (\Exception $e) {
            return $this->errorPage('查询域名数据异常');
        }
        if (is_null($domainDB) && !is_array($domainDB)) {
            //查询结果没有绑定的话，返回错误提示
            return $this->errorPage('访问的域名没有绑定');
        }

        if (!$this->allowBrowse($referer, $domainDB)) {
            //不允许访问，跳转默认设置页面
            $pageName = 'ex';
        }

        try {
            //查询落地页，
            $where = ['page_domain_id' => $domainDB['domain_id'], 'page_name' => $pageName];
            $page = Db::name('page')
                ->join('domain', 'page_domain_id=domain_id')
                ->join('template', 'page_template_id=template_id')
                ->join('template_dir', 'template_dir_id=_template_dir_id')
                ->join('brand', 'page_brand_id=brand_id')
                ->where($where)
                ->find();
            //查询推广线索的扩展参数
            $defines = Db::name('brand_define_list')
                ->join('brand_define', 'bd_id=bdl_define_id')
                ->where('bdl_brand_id', $page['brand_id'])->select();

        } catch (\Exception $exception) {
            return $this->errorPage('查询页面数据异常');
            // Log::record('执行查询落地页数据库失败。'.$exception,'error');
        }
        if (is_null($page) && !is_array($page)) {
            //访问的落地页不存在的话，返回错误
            return $this->errorPage('访问的页面不存在');
        } else {
            //落地页存在

            //访客记录(必须能正常访问该页面，才进行统计)
            $tongjiID = $this->tongJi($referer, $source, $keyword, $plan, $unit, $domain, $pageName, $searchKeyword);

            $def = [];//定义一个空的数组，用于储存循环读取到的扩展参数。
            if (is_array($defines)) {
                //如果该推广线索存在设置了扩展参数。
                foreach ($defines as $define) {
                    //循环读取设置的所有扩展参数，
                    $def['defines'][$define['bd_name']] = $define['bdl_define_var'];
                }
            }

            //把扩展参数合并到所有的参数里中去。
            $page = array_merge($page, $def);
            //dump($page);
            //输出所有参数到模板，使用$sh调用。
            $this->assign('sh', $page);
            $this->assign('tongji_id', $tongjiID);

            //这里只是去掉了文件后缀.html，因为带后缀$this->fetch会出错。
            $str = $page['template_name'];
            $pos = strripos($str, '.');
            $str = substr($str, 0, $pos);
            //动态改变一下模板路径。
            $this->view->config('view_path', $_SERVER['DOCUMENT_ROOT'] . '/public/static/template/');
            //输出相应的模板视图
            return $this->fetch($page['template_dir_name'] . '/' . $str);
        }
    }

    /**
     * note:允许哪些来源访问落地页，即允许哪些referer
     * @param $referer 'HTTP头referer的值'
     * @param $domainDB '查询domain表返回的数组'
     * @return bool
     */
    private function allowBrowse($referer, $domainDB)
    {
        if (!empty($referer)) {
            //如果前一页URL不为空的话。
            $host = parse_url($referer, PHP_URL_HOST);//获取域名部分
        } else {
            //为空。
            $host = '';
        }
        //如果站点允许来源有值的话，表示设置了允许来源，为空表示不限制访问
        if (!empty($domainDB['domain_source_allow'])) {
            //设置了允许来源，进行限制访问
            try {
                //设置的值格式为1,2,3  每个数字表示source_id
                $sources = Db::name('source')->where('source_id', 'in', $domainDB['domain_source_allow'])->select();
                //上面按照ID进行查询
            } catch (\Exception $e) {
                $sources = [];
            }
            $allow = false;
            foreach ($sources as $source) {
                //判断来源的特征码是否存在于URL中。
                $allow = strpos($host, $source['source_feature']);
                if ($allow !== false) {
                    //存在，表示允许来源访问，否则跳到默认页面
                    //跳出循环
                    break;
                }
            }
            if ($allow === false) {
                //不允许访问，跳转默认设置页面
                return false;
            } else {
                return true;
            }
        } else {
            //站点没有设置，表示允许所有跳转访问。
            return true;
        }
    }

    /**
     * note:记录访客的统计信息
     * @param $referer 'HTTP头信息里的referer值'
     * @param $source '渠道来源'
     * @param $keyword
     * @param $plan
     * @param $unit
     * @param $domain '受访站点的域名，不包含http://'
     * @param $pageName '受访的落地页名'
     * @param $searchKeyword '搜索词'
     * @return int '返回成功记录后的ID'
     */
    private function tongJi($referer, $source, $keyword, $plan, $unit, $domain, $pageName, $searchKeyword)
    {
        if (!empty($referer)) {
            //$url为HTTP头信息里的referer的值，即从哪个页面链接跳转过来的，
            //不为空的话，表示referer不为空，有上一跳转Url。而不是直接访问
            $isTongJi = $this->refererIsSource($referer);//如果referer不包含在t_source表里
            if (!$isTongJi) {
                //如果$isTongJi变量还是为false,则未找到，不进行统计。
                return 0;
            }
            $data = [
                'tj_source' => $source,
                'tj_keyword' => $keyword,
                'tj_plan' => $plan,
                'tj_unit' => $unit,
                'tj_search_keyword' => $searchKeyword,
                'tj_domain' => $domain,
                'tj_page_name' => $pageName,
                'tj_create_time' => date('Y-m-d H:i:s'),
                'tj_device' => $this->request->isMobile() ? 'YD' : 'PC',
                'tj_ip' => $this->request->ip()
            ];

            //先计算今日还余下多少秒
            $lastSeconds=strtotime(date('Y-m-d 23:59:59'));//获取当天最后一秒时间戳
            $nowSeconds=time();//获取当前的时间戳
            $remaining=$lastSeconds-$nowSeconds;//今日还余下的时间戳(秒)

            $token=sha1(md5($nowSeconds).'shiroo.cn');//系统自动生成一个token

            if(!Cookie::has('token','tongji_')){
                //如果Cookie里不存在token，表示新访客
                Cookie::set('token',$token,['prefix'=>'tongji_','expire'=>$remaining]);
            }else{
                //存在的话，获取并存到临时变量里。
                $tokenCookie=Cookie::get('token','tongji_');
                //验证token的合法性
                if(preg_match('/[a-z0-9]{40}/',$tokenCookie)){
                    //合法的话，就覆盖掉系统自动生成的$token变量
                    $token=$tokenCookie;
                }
            }
            $data['tj_token']=$token;//data数组新增一个token数据。
            //先查询当前的token是否存在于表里。

            try{
                $result=Tongji::where('tj_token',$token)->find();
                //$db=Tongji::where('tj_token',$token)->select();
                //$db=Db::name('tongji')->where('tj_token',$token)->find();
            }catch (\Exception $e){
                $result=null;
            }
            if(empty($result)){
                //如果该token不存在表里的话，就插入新记录。
                $tjModel=new Tongji();
                $row=$tjModel->allowField(true)->save($data);//返回的是影响行数
                if($row>0){
                    $id=$tjModel->tj_id;
                }else{
                    $id=0;
                }
            }else{
                //存在的话就直接返回该记录的ID
                $id=$result->tj_id;
                //$id=$db['tj_id'];
            }
            /*if(is_null($db) && !is_array($db) && empty($db)){
                //如果该token不存在表里的话，就插入新记录。

                $id=Db::name('tongji')->insertGetId($data);
            }else{
                //存在的话就直接返回该记录的ID
                $id=$db['tj_id'];
            }*/
            return (int)$id;
        } else {
            //表示为直接访问，不记录统计信息。
            return 0;
        }
    }

    /**
     * note:从referer里获取来源搜索引擎的搜索词。
     * @param $referer 'HTTP头的referer的值'
     * @return string
     */
    private function getSearchKeyword($referer)
    {
        if (!empty($referer)) {
            $host = parse_url($referer, PHP_URL_HOST);//获取域名部分
            $query = parse_url($referer, PHP_URL_QUERY);//获取参数部分

            $queryParts = explode('&', $query);//参数部分进行分割
            $params = [];//定义一个空的数组
            foreach ($queryParts as $param) {//这里的作用主要是把参数部分转变数组
                $item = explode('=', $param);//把参数名与参数值分割
                if (count($item) > 1) {
                    $params[$item[0]] = $item[1];//调用示例：$params[参数名]
                }
            }

            if (strpos($host, 'so.com') !== false) {
                //360
                $resultStr = isset($params['q']) ? $params['q'] : '';

            } elseif (strpos($host, 'sogou.com') !== false) {
                //搜狗
                $resultStr = isset($params['keyword']) ? $params['keyword'] : '';

            } elseif (strpos($host, 'baidu.com') !== false) {
                //百度
                $resultStr = isset($params['word']) ? $params['word'] : '';

            } elseif (strpos($host, 'sm.cn') !== false) {
                //神马
                $resultStr = isset($params['keyword']) ? $params['keyword'] : '';

            } elseif (strpos($host, '192.168.1.7') !== false) {
                //神马
                $resultStr = '本地测试搜索词';

            } else {
                $resultStr = '';
            }
            return urldecode($resultStr);
        } else {
            return '';
        }
    }

    /**
     * note:在source表里定义来源特征码，判断特征码是否与referer的值对应
     * @param $referer 'HTTP头里的referer的值'
     * @return bool
     */
    private function refererIsSource($referer)
    {
        $host = parse_url($referer, PHP_URL_HOST);//获取域名部分

        //从source数据表里读取出定义的来源页面url（如：baidu.com;sogou.com;so.com;sm.cn）
        /*try {
            $sourceDB = Db::name('source')->select();
        } catch (\Exception $e) {
            $sourceDB = [];
        }*/
        $sourceDB=[
            ['source_feature'=>'baidu.com'],
            ['source_feature'=>'sogou.com'],
            ['source_feature'=>'so.com'],
            ['source_feature'=>'sm.cn'],
            ['source_feature'=>'192.168.1.7']
        ];
        $isExist = false;//定义一个为假的变量
        foreach ($sourceDB as $source) {
            //循环从数据库里读出来的数组。
            $isExist = strpos($host, $source['source_feature']);//查找数据库定义的特征码是否存在于$host里。如果未找到则返回false
            if ($isExist !== false) {
                //如果返回结果为找到的话。则跳出循环
                break;
            }
        }

        if ($isExist === false) {
            //如果$isTongJi变量还是为false,则未找到，不进行统计。
            return false;
        } else {
            return true;
        }
    }
}
