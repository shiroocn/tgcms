<?php
/**
 * Created by PhpStorm.
 * User: xkq72
 * Date: 2019/4/4
 * Time: 23:12
 */

namespace app\admin\controller;

use think\Db;
use app\admin\model\Tongji as TongjiModel;

class Tongji extends Base
{
    public function show()
    {
        if (IS_POST) {
            $params = $this->request->param();
            //此处应有检验安全性代码

            //传参赋值
            $page = !empty($params['page'])?$params['page'] - 1:0;//页数
            $limit = !empty($params['limit'])?$params['limit']:10;//一页显示多少记录
            $domainURL = !empty($params['domain_url'])?$params['domain_url']:'';//查询的域名
            $source = !empty($params['source'])?$params['source']:'';//查询的平台
            $device = !empty($params['device'])?$params['device']:'';//查询的设备（PC，YD）
            $zhuanhua=!empty($params['zhuanhua'])?$params['zhuanhua']:'';//转化
            $startTime=!empty($params['start_time'])?$params['start_time']:'';//开始时间
            $endTime=!empty($params['end_time'])?$params['end_time']:'';//结束时间
            //$export=isset($postData['export'])?(int)$postData['export']:0;//是否为导出。


            //如果时间是空的话，就默认为今天时间
            $startTime = empty($startTime) ? date('Y-m-d 00:00:00') : $startTime . ' 00:00:00';
            $endTime = empty($endTime) ? date('Y-m-d 23:59:59') : $endTime . ' 23:59:59';

            $where = [
                ['tj_create_time', '>=', $startTime],
                ['tj_create_time', '<=', $endTime]
            ];

            //如果传递过来的这几个参数的值为all，表示查询全部就不用添加where条件，否则往where数组末尾压入查询条件
            if($domainURL!=='all'){
                array_push($where, ['tj_domain', '=', $domainURL]);
            }
            if($source!=='all'){
                array_push($where, ['tj_source', '=', $source]);
            }else{
                array_push($where, ['tj_source', 'in', $this->source]);
            }
            if($device!=='all'){
                array_push($where, ['tj_device', '=', $device]);
            }

            switch ($zhuanhua){
                case 'yes':
                    array_push($where,['tj_zhuanhua','=','1']);
                    break;
                case 'no':
                    array_push($where,['tj_zhuanhua','=','0']);
                    break;
            }

            try {
                if($export==1){
                    //导出操作，
                    $result=TongjiModel::where($where)
                        ->order('tj_create_time','desc')
                        ->select();
                }else{
                    //正常查询，包含得有$page和$limit
                    $result = TongjiModel::where($where)
                        ->limit($page * $limit, $limit)
                        ->order('tj_create_time', 'desc')
                        ->select();
                }

                $count = TongjiModel::where($where)->count('tj_id');//访客数
                $zhCount=TongjiModel::where($where)->where('tj_zhuanhua',1)->count();//转化数
                //计算转化率
                if ($count > 0) {
                    $zhl = round($zhCount / $count * 100, 2);
                } else {
                    $zhl = 0;
                }
            } catch (\Exception $e) {
                return json_shiroo('database');
            }
            return json_shiroo(0, 'page:' . $page . ',limit:' . $limit, $count, $result, ['zh_count' => $zhCount, 'zhl' => $zhl]);
        } else {
            //站点列表
            $domainList = Db::name('domain')->select();
            $sources=Db::name('source')->select();

            $this->assign('domains', $domainList);
            $this->assign('sources',$sources);
            return $this->fetch();
        }
    }

    public function export()
    {
        if (IS_POST) {
            $postData = $this->request->param();

            $domainURL = $postData['domain_url'];
            $source = $postData['source'];
            $device = $postData['device'];
            $startTime=$postData['start_time'];
            $endTime=$postData['end_time'];

            //如果时间是空的话，就默认为今天时间
            $startTime = empty($postData['start_time']) ? date('Y-m-d 00:00:00') : $postData['start_time'] . ' 00:00:00';
            $endTime = empty($postData['end_time']) ? date('Y-m-d 23:59:59') : $postData['end_time'] . ' 23:59:59';

            $where = [
                ['tj_create_time', '>', $startTime],
                ['tj_create_time', '<', $endTime]
            ];

            //如果传递过来的这几个参数的值为all，表示查询全部就不用添加where条件，否则往where数组末尾压入查询条件
            $domainURL == 'all' ?: array_push($where, ['tj_domain', '=', $domainURL]);

            $source == 'all' ? array_push($where, ['tj_source', 'in', $this->source]) : array_push($where, ['tj_source', '=', $postData['source']]);

            $device == 'all' ?: array_push($where, ['tj_device', '=', $postData['device']]);

            $result = TongjiModel::where($where)->order('tj_create_time', 'desc')->select();

            $count = Db::name('tongji')
                ->where($where)
                ->count('tj_id');

            //今日转化数
            $zhCount = Db::name('tongji')
                ->where($where)
                ->where('tj_zhuanhua', 1)
                ->count();
            //今日转化率
            if ($count > 0) {
                $zhl = round($zhCount / $count * 100, 2);
            } else {
                $zhl = 0;
            }
            return json_shiroo(0, '', $count, $result, ['zh_count' => $zhCount, 'zhl' => $zhl]);
        }
    }
}