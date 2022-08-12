<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: pl125 <xskjs888@163.com>
// +----------------------------------------------------------------------
namespace api\portal\controller;

use api\portal\service\PortalPostService;
use cmf\controller\RestUserBaseController;
use api\portal\logic\PortalPostModel;
use think\db\Query;

class UserArticlesController extends RestUserBaseController
{
    /**
     *
     * @OA\Get(
     *     summary="我的文章列表（用户文章列表）",
     *     tags={"portal"},
     *     path="/portal/articles/my",
     *     @OA\Parameter(ref="#/components/parameters/DeviceTypeParameter"),
     *     @OA\RequestBody(
     *         description="请求参数",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     description="文章id",
     *                     type="intger"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200"),
     *     security={{"ApiToken-XX-Token":{}},{"ApiToken-Authorization":{}},{"ApiToken-AuthorizationBearer":{}}}
     * )
     * 用户文章列表
     * @OA\Get(
     *     summary="用户文章列表（我的文章列表）",
     *     tags={"portal"},
     *     path="/portal/user/articles",
     *     @OA\Parameter(ref="#/components/parameters/DeviceTypeParameter"),
     *     @OA\RequestBody(
     *         description="请求参数",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     description="文章id",
     *                     type="intger"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200"),
     *     security={{"ApiToken-XX-Token":{}},{"ApiToken-Authorization":{}},{"ApiToken-AuthorizationBearer":{}}}
     * )
     */
    public function index()
    {
        $params = $this->request->param();
        $postModel = new PortalPostModel();
        $data = $postModel->getUserArticles($this->getUserId(), $params);
        if (empty($this->apiVersion) || $this->apiVersion == '1.0.0') {
            $response = $data;
        } else {
            $response = ['list' => $data];
        }

        $this->success('请求成功!', $response);
    }

    /**
     * 用户保存新建文章
     * @OA\Post(
     *     tags={"portal"},
     *     path="/portal/user/articles",
     *     @OA\Parameter(ref="#/components/parameters/DeviceTypeParameter"),
     *     @OA\RequestBody(
     *         description="请求参数",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     description="文章id",
     *                     type="intger"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200"),
     *     security={{"ApiToken-XX-Token":{}},{"ApiToken-Authorization":{}},{"ApiToken-AuthorizationBearer":{}}}
     * )
     */
    public function save()
    {
        $dates = $this->request->post();
        $dates['user_id'] = $this->getUserId();
        $result = $this->validate($dates, 'Articles.article');
        if ($result !== true) {
            $this->error($result);
        }
        if (empty($dates['published_time'])) {
            $dates['published_time'] = time();
        }
        $postModel = new PortalPostModel();
        $postModel->addArticle($dates);
        $this->success('添加成功！');
    }

    /**
     * 用户指定的文章
     * @param $id
     * @OA\Get(
     *     tags={"portal"},
     *     path="/portal/user/articles/{id}",
     *     @OA\Parameter(ref="#/components/parameters/DeviceTypeParameter"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="文章id",
     *         required=true,
     *         @OA\Schema(type="string",format="int32")
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200"),
     *     security={{"ApiToken-XX-Token":{}},{"ApiToken-Authorization":{}},{"ApiToken-AuthorizationBearer":{}}}
     * )
     */
    public function read($id)
    {
        if (empty($id)) {
            $this->error('无效的文章id');
        }
        $params = $this->request->param();
        $params['id'] = $id;
        $userId = $this->getUserId();
        $portalModel = PortalPostModel::with([
            'articleUser',
            'categories'
        ])
            ->where('id', $id)
            ->where('user_id', $userId);
        $dates = $portalModel->where('delete_time', 0)->find();
        $this->success('请求成功!', $dates);
    }

    /**
     * 用户保存更新指定的文章
     * @param $id
     * @OA\Put(
     *     tags={"portal"},
     *     path="/portal/user/articles/{id}",
     *     @OA\Parameter(ref="#/components/parameters/DeviceTypeParameter"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="文章id",
     *         required=true,
     *         @OA\Schema(type="string",format="int32")
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200"),
     *     security={{"ApiToken-XX-Token":{}},{"ApiToken-Authorization":{}},{"ApiToken-AuthorizationBearer":{}}}
     * )
     */
    public function update($id)
    {
        $data = $this->request->put();
        $result = $this->validate($data, 'Articles.article');
        if ($result !== true) {
            $this->error($result);
        }
        if (empty($id)) {
            $this->error('无效的文章id');
        }
        $postModel = new PortalPostModel();
        $result = $postModel->editArticle($data, $id, $this->getUserId());
        if ($result === false) {
            $this->error('编辑失败！');
        } else {
            $this->success('编辑成功！');
        }
    }

    /**
     * 用户删除指定文章
     * @param $id
     * @OA\Delete(
     *     tags={"portal"},
     *     path="/portal/user/articles/{id}",
     *     @OA\Parameter(ref="#/components/parameters/DeviceTypeParameter"),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="文章id",
     *         required=true,
     *         @OA\Schema(type="string",format="int32")
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200"),
     *     security={{"ApiToken-XX-Token":{}},{"ApiToken-Authorization":{}},{"ApiToken-AuthorizationBearer":{}}}
     * )
     */
    public function delete($id)
    {
        if (empty($id)) {
            $this->error('无效的文章id');
        }
        $postModel = new PortalPostModel();
        $result = $postModel->deleteArticle($id, $this->getUserId());
        if ($result == -1) {
            $this->error('文章已删除');
        }
        if ($result) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 用户批量删除文章指定文章
     * @OA\Put(
     *     tags={"portal"},
     *     path="/portal/user/articles/deletes",
     *     @OA\Parameter(ref="#/components/parameters/DeviceTypeParameter"),
     *     @OA\RequestBody(
     *         description="请求参数",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="ids",
     *                     description="文章ids",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,ref="#/components/responses/200"),
     *     security={{"ApiToken-XX-Token":{}},{"ApiToken-Authorization":{}},{"ApiToken-AuthorizationBearer":{}}}
     * )
     */
    public function deletes()
    {
        $ids = $this->request->param('ids');
        if (empty($ids)) {
            $this->error('文章id不能为空');
        }
        $postModel = new PortalPostModel();
        $result = $postModel->deleteArticle($ids, $this->getUserId());
        if ($result == -1) {
            $this->error('文章已删除');
        }
        if ($result) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }
}