<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2018/10/18
 * Time: 10:19
 */

namespace app\admin\controller;


class File extends Base
{
    public function upload(){
        if(IS_POST){
            $file=$this->request->file('file');
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
                echo $info->getSaveName();
                return true;
            }else{
                //上传失败
                echo $file->getError();
                return false;
            }
        }else{
            return $this->fetch();
        }
    }
    public function show(){


    }
}