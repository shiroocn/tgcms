<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/4/26
 * Time: 10:36
 */

namespace app\admin\model;


use think\Model;

class Domain extends Model
{
    protected $pk='domain_id';//默认主键。

    public function getDomainCopyrightAttr($value){
        return base64_decode($value);
    }
    public function setDomainCopyrightAttr($value){
        return base64_encode($value);
    }
    public function getDomainCountCodeAttr($value){
        return base64_decode($value);
    }
    public function setDomainCountCodeAttr($value){
        return base64_encode($value);
    }
    public function getDomainRestrictedAreaAttr($value){
        return base64_decode($value);
    }
    public function setDomainRestrictedAreaAttr($value){
        return base64_encode($value);
    }
}