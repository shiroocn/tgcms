<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/6/2
 * Time: 22:47
 */

namespace app\index\controller;

use think\Controller;
use think\Db;

class Base extends Controller{
    public function initialize()
    {
        define('UPLOADS_PATH','/uploads');
    }

    protected function getSearchKeyword($referer)
    {
        if (!empty($referer)) {
            $host = parse_url($referer, PHP_URL_HOST);//获取域名部分
            $query = parse_url($referer, PHP_URL_QUERY);//获取参数部分
            if(!empty($host) && !empty($query)){
                $queryParts = explode('&', $query);//参数部分进行分割
                $params = [];//定义一个空的数组
                foreach ($queryParts as $param) {//这里的作用主要是把参数部分转变数组
                    $item = explode('=', $param);//把参数名与参数值分割
                    if (count($item) > 1) {
                        $params[$item[0]] = $item[1];//调用示例：$params[参数名]
                    }
                }
                if(!empty($params)){//如果为空，则URL里不存在参数，或者是获取失败。
                    try{
                        $sources=Db::name('source')->select();//查询结果是一个二维数组，如果结果不存在，返回空数组
                    }catch (\Exception $exception){
                        $sources=[];
                    }
                    if(!empty($sources)){//判断从数据库里读取到的来源数据是否为空
                        $resultStr='';
                        foreach ($sources as $source){
                            //循环数据库中取到的来源列表。
                            if(strpos($host,$source['source_feature'])!==false){
                                //如果当前的$host与来源列表某一记录匹配的话。
                                $keyNames=explode(',',$source['source_key_name']);
                                foreach ($keyNames as $keyName){
                                    //因为keyNames是一维数组，所以这里直接获得的就是值。
                                    if(isset($params[$keyName])){//判断是否存在该数组
                                        $resultStr=$params[$keyName];//存在的话就取值
                                    }else{
                                        $resultStr='';//不存在的话就返回空
                                    }
                                    if(!empty($resultStr)){
                                        //如果不为空的话，表示取到值了，直接跳出循环。
                                        //因为有的来源设置了多个搜索词参数名，
                                        $resultStr=urldecode($resultStr);
                                        break;
                                    }
                                }
                                break;
                            }
                        }
                        return $resultStr;
                    }else{
                        //数据库里不存在来源记录
                        return '';
                    }
                }else{
                    //url里不存在任何参数。
                    return '';
                }
            }else{
                return '';
            }
        } else {
            return '';
        }
    }
    protected function allowCity($domain_restricted_area){
        try{
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept-language: zh-CN,zh;q=0.9\r\n" .
                        "Cookie: foo=bar\r\n",
                    'timeout'=>5
                )
            );
            $context = stream_context_create($opts);
            $htmlCode=file_get_contents('http://ip.ws.126.net/ipquery?ip='.$this->request->ip(),false,$context);
        }catch (\Exception $exception){
            $htmlCode='';
        }
        if(!empty($htmlCode)){
            //获取城市名
            $isMatched1 = preg_match('/city:"(\S+)"/', $htmlCode, $city);
            if($isMatched1){
                if(isset($city[1])){
                    $cityStr=iconv('GB2312','UTF-8',$city[1]);
                }else{
                    $cityStr='';
                }
            }else{
                $cityStr='';
            }
            //获取省份名
            $isMatched2 = preg_match('/province:"(\S+)"/', $htmlCode, $province);
            if($isMatched2){
                if(isset($province[1])){
                    $provinceStr=iconv('GB2312','UTF-8',$province[1]);
                }else{
                    $provinceStr='';
                }
            }else{
                $provinceStr='';
            }
            //$domain_restricted_area的数据格式：珠海,深圳,广州,香港
            $domainRestrictedArea=explode(',',$domain_restricted_area);
            if(!empty($domainRestrictedArea)){
                $existence=false;
                foreach ($domainRestrictedArea as $v){
                    $a=strpos($cityStr,$v);//判断设置的值是否等于城市
                    $b=strpos($provinceStr,$v);//判断设置的值是否等于省份
                    if($a!==false || $b!==false){ //如果有其中一项包含，则表示不允许访问
                        $existence=true;
                        break;
                    }
                }
                if($existence){
                    //访客的地区存在于禁止访问列表里
                    return false;//不允许访问
                }else{
                    return true;
                }
            }else{
                //如果数据库里没有设置禁止访问的城市，直接放行。
                return true;
            }
        }else{
            //获取不到IP所在归属地信息。直接允许访问
            return true;
        }
    }
    protected function allowBrowse($referer, $domain_source_allow)
    {
        if (!empty($referer)) {
            $host = parse_url($referer, PHP_URL_HOST);//获取域名部分
            if(!empty($host)){
                $directAccess=false;//跳转访问
            }else{
                $directAccess=true;//直接访问
            }
        } else {
            $host = '';
            $directAccess=true;//直接访问
        }

        //如果站点允许来源有值的话，表示设置了允许来源，为空表示不限制访问
        if (!empty($domain_source_allow)) {
            //设置了允许来源，进行限制访问
            if($directAccess){
                //设置了来源限制，并且为直接访问，那直接就不允许
                return false;
            }
            //查询设置的是哪些
            try {
                //设置的值格式为1,2,3  每个数字表示source_id
                $sources = Db::name('source')->where('source_id', 'in', $domain_source_allow)->select();
                //上面按照ID进行查询
            } catch (\Exception $e) {
                $sources = [];
            }
            $allow = false;
            foreach ($sources as $source) {
                //判断来源的特征码是否存在于URL中。
                $allow = strpos($host, $source['source_feature']);//查找$source['source_feature']特征码是否存在于$host中。不存在返回false，
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

    public function errorPage($title='',$content=''){
        return $this->fetch('public/error',['title'=>$title,'content'=>$content]);
    }
}