<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/9/4
 * Time: 10:16
 */

namespace app\admin\controller;


use think\Db;

class Page extends Base
{
    public function index(){

    }
    public function add(){

    }
    public function del(){

    }
    public function edit(){

    }
    public function show(){
        try{
            $pageDB=Db::name('page')
                ->join('domain','page_domain_id=domain_id')
                ->join('model','page_model_id=model_id')
                ->join('user','page_user_id=user_id')
                ->select();
        }catch (\Exception $e){

        }

        return $this->fetch();
    }
}