<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: pl125 <xskjs888@163.com>
// +----------------------------------------------------------------------
namespace api\portal\controller;

use api\portal\model\PortalTagModel;
use api\portal\service\PortalTagService;
use cmf\controller\RestBaseController;
use think\db\Query;

class TagsController extends RestBaseController
{

    /**
     * 获取标签列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @OA\Get(
     *     tags={"portal"},
     *     path="/portal/tags",
     *     @OA\Response(response=200,ref="#/components/responses/200")
     * )
     */
    public function index()
    {
        $params     = $this->request->get();
        $tagService = new PortalTagService();
        $data       = $tagService->tagList($params);

        if (empty($this->apiVersion) || $this->apiVersion == '1.0.0') {
            $response = $data;
        } else {
            $response = ['list' => $data,];
        }
        if ($data->isEmpty()) {
            $this->error('没有标签！');
        }
        $this->success('请求成功!', $response);
    }

    /**
     * 获取热门标签列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @OA\Get(
     *     tags={"portal"},
     *     path="/portal/tags/hot",
     *     @OA\Response(response=200,ref="#/components/responses/200")
     * )
     */
    public function hotTags()
    {
        $params  = $this->request->get();
        $params['recommended'] = true;
        $tagService = new PortalTagService();
        $data       = $tagService->tagList($params);

        if (empty($this->apiVersion) || $this->apiVersion == '1.0.0') {
            $response = $data;
        } else {
            $response = ['list' => $data];
        }
        $this->success('请求成功!', $response);
    }

    /**
     * 获取标签文章列表
     * @param $id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @OA\Get(
     *     tags={"portal"},
     *     path="/portal/tags/{id}/articles",
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
    public function articles($id)
    {
        if (intval($id) === 0) {
            $this->error('无效的标签id！');
        } else {
            $filter       = $this->request->param();
            $filter['id'] = $id;
            $tagService   = new PortalTagService();
            $tag          = $tagService->portalTagArticles($filter);
            if (empty($tag->articles) || $tag->articles->isEmpty()) {
                $this->error('没有相关文章');
            }
            $this->success('请求成功!', $tag);
        }
    }
}
