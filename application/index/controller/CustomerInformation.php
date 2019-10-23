<?php


namespace app\index\controller;

use app\index\model\CustomerInformation as CiModel;

class CustomerInformation extends Base
{
    public function add(){
        //收集电话线索
        $param=$this->request->param();

        //进行数据的检验,只允许字母与数字组合。
        $validate = $this->validate($param, 'app\index\validate\CustomerInformation.add');
        if ($validate !== true) {
            //如果检检验不过关，提示错误。
            return json_shiroo('validate', $validate);
        }
        $phone=$param['phone'];
        $createTime=time();

        $keyword = isset($param['keyword']) ? $param['keyword'] : '';//关键词
        $searchKeyword = isset($param['search_keyword']) ? $param['search_keyword'] : '';//关键词

        $data=[
            'ci_phone'=>$phone,
            'ci_create_time'=>$createTime,
            'ci_keyword'=>$keyword,
            'ci_search_keyword'=>$searchKeyword
        ];
        try{
            $ci=CiModel::create($data);
        }catch (\Exception $exception){
            return json_shiroo('database', $exception->getMessage());
        }
        return json_shiroo('add.success');
    }
}