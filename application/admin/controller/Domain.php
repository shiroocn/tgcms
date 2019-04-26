<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/10/18
 * Time: 10:18
 */

namespace app\admin\controller;


use think\Db;
use app\admin\model\Domain as DomainModel;

class Domain extends Base
{
    public function add(){
        if(IS_POST){
            //接收用户提交过来的POST数据，这里为一个数组数据
            $postData=$this->request->param();
            //进行数据的检验
            $validate=$this->validate($postData,'app\admin\validate\Domain.add');
            if($validate!==true){
                //如果检检验不过关，提示错误。
                return json_shiroo('validate',$validate);
            }
            $domainURL=$postData['domain_url'];
            $domainCopyright=isset($postData['domain_copyright'])?htmlentities($postData['domain_copyright']):'';
            $domainCountCode=isset($postData['domain_count_code'])?htmlentities($postData['domain_count_code']):'';
            $domainRestrictedArea=isset($postData['domain_restricted_area'])?$postData['domain_restricted_area']:'';
            $domainSourceAllow=isset($postData['sources'])?implode(',',$postData['sources']):null;
            $aaaa=preg_match('/^[0-9,]+$/',$domainSourceAllow);
            if(($aaaa<1 || $aaaa==false) && !empty($domainSourceAllow)){
                //表示$postData['sources']传递进来的数据不合法。
                return json_shiroo('validate','sources参数包含不允许的字符');
            }

            //添加进数据库。
            $data=[
                'domain_url'=>$domainURL,
                'domain_copyright'=>$domainCopyright,
                'domain_count_code'=>$domainCountCode,
                'domain_source_allow'=>$domainSourceAllow,
                'domain_restricted_area'=>$domainRestrictedArea
            ];
            try{
                $domainM=new DomainModel();
                $row=$domainM->allowField(true)->save($data);
            }catch (\Exception $e){
                return json_shiroo('database','新增数据异常，请重试！');
            }
            if($row>0 && $row!=false){
                return json_shiroo('add.success');
            }else{
                return json_shiroo('add.error');
            }
        }else{
            //没有提交数据，直接显示添加页面
            return $this->fetch();
        }
    }
    public function show(){
        if(IS_POST){
            $postData=$this->request->param();
            //进行数据的检验
            $validate=$this->validate($postData,'app\admin\validate\Domain.show');
            if($validate!==true){
                //如果检检验不过关，提示错误。
                return json_shiroo('validate',$validate);
            }

            $page=isset($postData['page'])?(int)$postData['page']-1:0;
            $limit=isset($postData['limit'])?(int)$postData['limit']:0;

            try{
                $result=DomainModel::limit($page*$limit,$limit)->order('domain_id','asc')->select();
                $count=Db::name('domain')->count('domain_id');
            }catch (\Exception $e){
                return json_shiroo(10,'没有获取到数据，可能是出错了。',0,[]);
            }
            return json_shiroo(0,'page:'.$page.',limit:'.$limit,$count,$result);
        }else{
            //查询允许来源列表数据，
            try{
                $sources=Db::name('source')->select();//如果不存在返回的是空数组。
            }catch (\Exception $e){
                $sources=[];
            }
            $this->assign('sources',$sources);//用于新增与编辑的时候供选择
            return $this->fetch();
        }
    }
    public function edit(){
        $postData=$this->request->param();
        //进行数据校验
        $validate=$this->validate($postData,'app\admin\validate\Domain.edit');
        if($validate!==true){
            return json_shiroo('validate',$validate);
        }
        $domainID=$postData['domain_id'];
        $domainCopyright=isset($postData['domain_copyright'])?htmlentities($postData['domain_copyright']):'';
        $domainCountCode=isset($postData['domain_count_code'])?htmlentities($postData['domain_count_code']):'';
        $domainRestrictedArea=isset($postData['domain_restricted_area'])?$postData['domain_restricted_area']:'';
        $domainSourceAllow=isset($postData['sources'])?implode(',',$postData['sources']):null;
        $aaaa=preg_match('/^[0-9,]+$/',$domainSourceAllow);
        if(($aaaa<1 || $aaaa==false) && !empty($domainSourceAllow)){
            //表示$postData['sources']传递进来的数据不合法。
            return json_shiroo('validate','sources参数包含不允许的字符');
        }
        $data=[
            'domain_id'=>$domainID,
            'domain_copyright'=>$domainCopyright,
            'domain_count_code'=>$domainCountCode,
            'domain_source_allow'=>$domainSourceAllow,
            'domain_restricted_area'=>$domainRestrictedArea
        ];
        try{
            $domainM=new DomainModel();
            $row=$domainM->save($data,['domain_id'=>$domainID]);
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($row>0 && $row!=false){
            return json_shiroo('edit.success');
        }else{
            return json_shiroo('edit.error');
        }
    }
    public function del(){
        $postData=$this->request->param();
        //进行数据校验
        $validate=$this->validate($postData,'app\admin\validate\Domain.delete');
        if($validate!==true){
            return json_shiroo('validate',$validate);
        }
        $postID=$postData['domain_id'];
        try{
            $result=Db::name('domain')->where('domain_id',$postID)->delete();
            $page=Db::name('page')->where('page_domain_id',$postID)->delete();
        }catch (\Exception $e){
            return json_shiroo('database');
        }
        if($result>0 && $page>=0){
            return json_shiroo('del.success','',$result);
        }else{
            return json_shiroo('del.error');
        }
    }
}