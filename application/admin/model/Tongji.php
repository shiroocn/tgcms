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
        return base64_decode($value);
    }
    public function setTjKeywordAttr($value){
        return base64_encode($value);
    }
    public function getTjPlanAttr($value){
        return base64_decode($value);
    }
    public function setTjPlanAttr($value){
        return base64_encode($value);
    }
    public function getTjUnitAttr($value){
        return base64_decode($value);
    }
    public function setTjUnitAttr($value){
        return base64_encode($value);
    }
    public function getTjStrAttr($value){
        return base64_decode($value);
    }
    public function setTjStrAttr($value){
        return base64_encode($value);
    }
    public function getTjSearchKeywordAttr($value){
        return base64_decode($value);
    }
    public function setTjSearchKeywordAttr($value){
        return base64_encode($value);
    }
}