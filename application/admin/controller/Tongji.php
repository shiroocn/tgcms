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
    protected $source = ['360', 'sogou', 'baidu', 'sm', 'localhost'];

    public function show()
    {
        if (IS_POST) {
            $postData = $this->request->param();
            //此处应有检验安全性代码
            //传参赋值
            $page = $postData['page'] - 1;
            $limit = $postData['limit'];
            $domainURL = $postData['domain_url'];
            $source = $postData['source'];
            $device = $postData['device'];

            //如果时间是空的话，就默认为今天时间
            $startTime = empty($postData['start_time']) ? date('Y-m-d 00:00:00') : $postData['start_time'] . ' 00:00:00';
            $endTime = empty($postData['end_time']) ? date('Y-m-d 23:59:59') : $postData['end_time'] . ' 23:59:59';
            $where = [
                ['tj_create_time', '>', $startTime],
                ['tj_create_time', '<', $endTime],
                ['tj_load_done', '=', 1]
            ];

            //如果传递过来的这几个参数的值为all，表示查询全部就不用添加where条件，否则往where数组末尾压入查询条件
            $domainURL == 'all' ?: array_push($where, ['tj_domain', '=', $domainURL]);

            $source == 'all' ? array_push($where, ['tj_source', 'in', $this->source]) : array_push($where, ['tj_source', '=', $postData['source']]);

            $device == 'all' ?: array_push($where, ['tj_device', '=', $postData['device']]);

            try {
                $result = TongjiModel::where($where)
                    ->limit($page * $limit, $limit)
                    ->order('tj_create_time', 'desc')
                    ->select();
                /*$result = Db::name('tongji')
                    ->limit($page * $limit, $limit)
                    ->where($where)
                    ->order('tj_create_time', 'desc')
                    ->select();*/
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
            } catch (\Exception $e) {
                return json_shiroo('database');
            }
            return json_shiroo(0, 'page:' . $page . ',limit:' . $limit, $count, $result, ['zh_count' => $zhCount, 'zhl' => $zhl]);
        } else {
            //站点列表
            $domainList = Db::name('domain')->select();

            $this->assign('domains', $domainList);
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

            //如果时间是空的话，就默认为今天时间
            $startTime = empty($postData['start_time']) ? date('Y-m-d 00:00:00') : $postData['start_time'] . ' 00:00:00';
            $endTime = empty($postData['end_time']) ? date('Y-m-d 23:59:59') : $postData['end_time'] . ' 23:59:59';

            $where = [
                ['tj_create_time', '>', $startTime],
                ['tj_create_time', '<', $endTime],
                ['tj_load_done', '=', 1]
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