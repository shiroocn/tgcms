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

    private function base64DecodeValue($value){
        if(!empty($value)){
            if(base64_encode(base64_decode($value))==$value){
                try{
                    $val=base64_decode($value);
                }catch (\Exception $exception){
                    $val=$exception->getMessage();
                }
                return $val;
            }else{
                return $value;
            }
        }else{
            return '';
        }
    }
    private function base64EncodeValue($value){
        if(!empty($value)){
            try{
                $val=base64_decode($value);
            }catch (\Exception $exception){
                $val=$exception->getMessage();
            }
            return $val;
        }else{
            return '';
        }
    }

    public function getTjKeywordAttr($value){
        return $this->base64DecodeValue($value);
    }
    public function setTjKeywordAttr($value){
        return $this->base64EncodeValue($value);
    }
    public function getTjPlanAttr($value){
        return $this->base64DecodeValue($value);
    }
    public function setTjPlanAttr($value){
        return $this->base64EncodeValue($value);
    }
    public function getTjUnitAttr($value){
        return $this->base64DecodeValue($value);
    }
    public function setTjUnitAttr($value){
        return $this->base64EncodeValue($value);
    }
    public function getTjStrAttr($value){
        return $this->base64DecodeValue($value);
    }
    public function setTjStrAttr($value){
        return $this->base64EncodeValue($value);
    }

    public function getTjSearchKeywordAttr($value){
        $val=$this->base64DecodeValue($value);
        //这里是因为在搜狗处发现有的会二次urlencode原始字符是%25xx%25xx%25xx,系统获取搜索词的时候会进行一次urldecode，但是还是url编码，这种字符串是gb2312，如果不进行转换直接urldecode会得到乱码。
        $isMatched = preg_match('/%\w{2,4}/', $val, $matches);
        if($isMatched){
            $val=iconv('gb2312','UTF-8',urldecode($val));
        }
        return $val;
    }
    public function setTjSearchKeywordAttr($value){
        return $this->base64EncodeValue($value);
    }
}