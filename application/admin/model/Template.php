<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/4/26
 * Time: 15:52
 */

namespace app\admin\model;


use think\Model;

class Template extends Model
{
    protected $pk='template_id';

    public function templateDir(){
        return $this->belongsTo('TemplateDir','_template_dir_id');
    }

}