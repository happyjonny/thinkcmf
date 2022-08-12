<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: pl125 <xskjs888@163.com>
// +----------------------------------------------------------------------

namespace api\portal\controller;

use api\portal\service\PortalCategoryService;
use cmf\controller\RestBaseController;
use api\portal\model\PortalCategoryModel;

class CategoriesController extends RestBaseController
{
    /**
     * 获取分类列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @OA\Get(
     *     tags={"portal"},
     *     path="/portal/categories",
     *     @OA\Response(response=200,ref="#/components/responses/200")
     * )
     */
    public function index()
    {

        $params          = $this->request->get();
        $categoryService = new PortalCategoryService();
        $data            = $categoryService->categories($params);
        if (empty($this->apiVersion) || $this->apiVersion == '1.0.0') {
            $response = $data;
        } else {
            $response = ['list' => $data];
        }

        $this->success('请求成功!', $response);
    }

    /**
     * 显示指定的分类
     * @param $id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @OA\Get(
     *     tags={"portal"},
     *     path="/portal/categories/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="分类id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200")
     * )
     */
    public function read($id)
    {
        $categoryModel = new PortalCategoryModel();
        $data          = $categoryModel
            ->where('delete_time', 0)
            ->where('status', 1)
            ->where('id', $id)
            ->find();
        if ($data) {
            $this->success('请求成功！', $data);
        } else {
            $this->error('该分类不存在！');
        }

    }

    /**
     * 获取指定分类的子分类列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @OA\Get(
     *     tags={"portal"},
     *     path="/portal/subcategories/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="分类id(可选参数)",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200")
     * )
     */
    public function subCategories($id = 0)
    {
        $id = intval($id);
        $categoryModel = new PortalCategoryModel();
        $categories    = $categoryModel->where(['parent_id' => $id])->select();
        if (!$categories->isEmpty()) {
            $this->success('请求成功', ['categories' => $categories]);
        } else if(!PortalCategoryModel::find($id)){
            $this->error('该分类不存在！');
        } else {
            $this->error('该分类下没有子分类！');
        }


    }
}
