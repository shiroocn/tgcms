<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/10/18
 * Time: 10:19
 */

namespace app\admin\controller;


use think\Db;

class File extends Base
{
    public function upload(){
        if(IS_POST){
            $file=$this->request->file('file');
            $updateIP=$this->request->ip();
            if(empty($file)){
                return '没有获取到上传文件。';
            }
            $info=$file->validate([
                'size'=>1048576,
                'ext'=>'jpg,png,gif'
            ])->rule('md5')->move('../uploads');
            //这里采用MD5来给文件重命名，前两个字符是文件夹名称。
            if($info){
                //上传成功
                $data=[
                    'file_name'=>$info->getFilename(),
                    'file_path'=>str_replace('\\','/',$info->getSaveName()),
                    'file_create_time'=>time(),
                    'file_md5'=>$info->hash('md5'),
                    'file_exists'=>1,
                    'file_upload_ip'=>$updateIP,
                    'file_admin_id'=>1,
                    'file_type'=>$info->getExtension(),
                    'file_size'=>$info->getSize()
                ];
                Db::name('file')->insert($data);
                var_dump($data);
                //return true;
            }else{
                //上传失败
                echo $file->getError();
                //return false;
            }
        }else{
            return $this->fetch();
        }
    }
    public function show(){
        try{
            $files=Db::name('file')->select();
        }catch (\Exception $e){
            $this->error('读取文件列表异常，请重试。');
        }
        $this->assign('files',$files);
        return $this->fetch();
    }
}