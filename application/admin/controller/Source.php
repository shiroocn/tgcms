<?php


namespace app\admin\controller;

use app\admin\model\Source as SourceModel;


class Source extends Base
{
    public function show(){
        if(IS_POST){
            $params = $this->request->param();
            //此处应有检验安全性代码

            //传参赋值
            $page = !empty($params['page'])?$params['page'] - 1:0;//页数
            $limit = !empty($params['limit'])?$params['limit']:10;//一页显示多少记录

            try{
                $source = SourceModel::limit($page * $limit, $limit)
                    ->order('source_id', 'asc')
                    ->select();
                $count=SourceModel::count('source_id');
            }catch (\Exception $exception){
                return shirooJson(1,$exception->getMessage());
            }
            return shirooJson(0,'',$count,['data'=>$source]);
        }else{
            return $this->fetch();
        }
    }
}