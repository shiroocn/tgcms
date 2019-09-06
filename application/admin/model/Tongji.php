<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/4/22
 * Time: 15:23
 */

namespace app\admin\model;


use think\Model;

class Tongji extends Model
{
    protected $pk='tj_id';//默认主键。

    public function getTjKeywordAttr($value){
        try{
            $val=base64_decode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }
    public function setTjKeywordAttr($value){
        try{
            $val=base64_encode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }


    public function getTjPlanAttr($value){
        try{
            $val=base64_decode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }
    public function setTjPlanAttr($value){
        try{
            $val=base64_encode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }


    public function getTjUnitAttr($value){
        try{
            $val=base64_decode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }
    public function setTjUnitAttr($value){
        try{
            $val=base64_encode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }

    public function getTjStrAttr($value){
        try{
            $val=base64_decode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }
    public function setTjStrAttr($value){
        try{
            $val=base64_encode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }

    public function getTjSearchKeywordAttr($value){
        try{
            $val=base64_decode($value);
            //这里是因为在搜狗处发现有的会二次urlencode原始字符是%25xx%25xx%25xx,系统获取搜索词的时候会进行一次urldecode，但是还是url编码，这种字符串是gb2312，如果不进行转换直接urldecode会得到乱码。
            $isMatched = preg_match('/%\w{2,4}/', $val, $matches);
            if($isMatched){
                $val=iconv('gb2312','UTF-8',urldecode($val));
            }
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }
    public function setTjSearchKeywordAttr($value){
        try{
            $val=base64_encode($value);
        }catch (\Exception $exception){
            $val=$value;
        }
        return $val;
    }
}