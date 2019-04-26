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
    public function index()
    {

    }

    public function add()
    {
        $postData = $this->request->param();
        $validate = $this->validate($postData, 'app\admin\validate\Page.add');
        if ($validate !== true) {
            //如果检检验不过关，提示错误。
            return json_shiroo('validate', $validate);
        }

        $domainID = $postData['domain_id'];
        $pageName = $postData['page_name'];
        $templateID = $postData['template_id'];
        $brandID = $postData['brand_id'];

        //这里当如果用户提交进来的是0，应该是可以成功提交并写入数据库的。

        $data = [
            'page_name' => $pageName,
            'page_template_id' => $templateID,
            'page_domain_id' => $domainID,
            'page_brand_id' => $brandID
        ];
        //这里先查询要新增的落地页是否已经存在。
        try {
            $result = Db::name('page')->where(['page_name' => $pageName, 'page_domain_id' => $domainID])->find();
        } catch (\Exception $e) {
            return json_shiroo('database');
        }
        if (!is_null($result)) {
            return json_shiroo('exist');
        }
        try {
            $result = Db::name('page')->insert($data);
        } catch (\Exception $e) {
            return json_shiroo('database');
        }
        if ($result) {
            return json_shiroo('add.success');
        } else {
            return json_shiroo('add.error');
        }
    }

    public function batchAdd()
    {
        $postData = $this->request->param();

        $validate = $this->validate($postData, 'app\admin\validate\Page.batchAdd');
        if ($validate !== true) {
            //如果检检验不过关，提示错误。
            return json_shiroo('validate', $validate);
        }

        $domainID = $postData['domain_id'];
        $pageNamePrefix = $postData['page_name_prefix'];
        $pageNameSuffixMin = $postData['page_name_suffix_min'];
        $pageNameSuffixMax = $postData['page_name_suffix_max'];
        $templateID = $postData['template_id'];
        $brandID = $postData['brand_id'];

        $data = [];
        for ($i = $pageNameSuffixMin; $i <= $pageNameSuffixMax; $i++) {
            array_push($data, array(
                    'page_name' => $pageNamePrefix . $i,
                    'page_template_id' => $templateID,
                    'page_domain_id' => $domainID,
                    'page_brand_id' => $brandID)
            );
        }
        $result = 0;
        try {
            $result = Db::name('page')->limit(100)->insertAll($data);
        } catch (\Exception $e) {
            return json_shiroo('add.error', '批量新增失败，可能存在重复。', $result);
        }
        return json_shiroo('add.success', '', $result);
    }

    public function del()
    {
        $postData = $this->request->param();
        //检验数据合法性
        $validate = $this->validate($postData, 'app\admin\validate\Page.delete');
        if ($validate !== true) {
            //如果检检验不过关，提示错误。
            return json_shiroo('validate', $validate);
        }

        $pageID = $postData['page_id'];
        try {
            $result = Db::name('page')->where('page_id', $pageID)->delete();
        } catch (\Exception $e) {
            return json_shiroo('database');
        }
        if ($result) {
            return json_shiroo('del.success');
        } else {
            return json_shiroo('del.error');
        }
    }

    public function edit()
    {
        $postData = $this->request->param();

        $validate = $this->validate($postData, 'app\admin\validate\Page.edit');
        if ($validate !== true) {
            return json_shiroo('validate', $validate);
        }

        $domainID = $postData['domain_id'];
        $pageID = $postData['page_id'];
        $templateID = $postData['template_id'];
        $brandID = $postData['brand_id'];
        $applyAllTemplate = isset($postData['apply_all_template']) ? $postData['apply_all_template'] : 'off';
        $applyAllBrand = isset($postData['apply_all_brand']) ? $postData['apply_all_brand'] : 'off';

        try {
            //这里是编辑当前记录
            $result = Db::name('page')->where('page_id', $pageID)
                ->update([
                    'page_template_id' => $templateID,
                    'page_brand_id' => $brandID
                ]);
            //如果客户选中了应用全部【模板】
            if ($applyAllTemplate == 'on') {
                Db::name('page')->where('page_domain_id', $domainID)
                    ->update([
                        'page_template_id' => $templateID
                    ]);
            }
            //如果客户选中了应用全部【线索】
            if ($applyAllBrand == 'on') {
                Db::name('page')->where('page_domain_id', $domainID)
                    ->update([
                        'page_brand_id' => $brandID
                    ]);
            }
        } catch (\Exception $e) {
            return json_shiroo('database');
        }
        if ($result) {
            return json_shiroo('edit.success');
        } else {
            return json_shiroo('edit.error');
        }
    }

    public function show()
    {
        $postData = $this->request->param();
        //检验数据有效性
        $validate = $this->validate($postData, 'app\admin\validate\Page.show');
        if ($validate !== true) {
            return json_shiroo('validate', $validate);
        }
        $domain_id = $postData['domain_id'];
        if (IS_POST) {
            $page = (int)$postData['page'] - 1;
            $limit = (int)$postData['limit'];
            try {
                $result = Db::name('page')
                    ->leftJoin('domain', 'page_domain_id=domain_id')
                    ->leftJoin('template', 'page_template_id=template_id')
                    ->leftJoin('template_dir', 'template_dir_id=_template_dir_id')
                    ->leftJoin('brand', 'page_brand_id=brand_id')
                    ->where('page_domain_id', $domain_id)
                    ->limit($page * $limit, $limit)
                    ->order('page_id', 'asc')
                    ->select();
                $count = Db::name('page')->where('page_domain_id', $domain_id)->count('page_id');
            } catch (\Exception $e) {
                return json_shiroo('database');
            }
            return json_shiroo(0, '', $count ?: 0, $result);
        } else {
            try {
                $brand = Db::name('brand')->select();
                $templateDir = Db::name('template_dir')->select();
            } catch (\Exception $e) {
                $this->error(err('database')['msg']);
            }
            $this->assign('brand', isset($brand) ? $brand : []);
            $this->assign('template_dir', isset($templateDir) ? $templateDir : []);
            $this->assign('domain_id', $domain_id);
            return $this->fetch();
        }
    }

    public function getTemplate()
    {
        $postData = $this->request->param();

        $validate = $this->validate($postData, 'app\admin\validate\Page.getTemplate');
        if ($validate !== true) {
            return json_shiroo('validate', $validate);
        }
        $templateDirID = $postData['template_dir_id'];

        try {
            $result = Db::name('template')->where('_template_dir_id', $templateDirID)->select();
        } catch (\Exception $e) {
            return json_shiroo('database');
        }
        return json_shiroo(0, '', count($result), $result);
    }
}