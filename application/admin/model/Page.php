<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/4/26
 * Time: 15:12
 */

namespace app\admin\model;


use think\Model;

class Page extends Model
{
    protected $pk='page_id';
    public function domain(){
        return $this->belongsTo('Domain','page_domain_id');
    }
    public function brand(){
        return $this->belongsTo('Brand','page_brand_id');
    }
    public function template(){
        return $this->belongsTo('Template','page_template_id');
    }
}