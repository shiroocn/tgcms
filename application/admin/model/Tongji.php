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