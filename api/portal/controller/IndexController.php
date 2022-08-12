<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: pl125 <xskjs888@163.com>
// +----------------------------------------------------------------------
namespace api\portal\controller;
use cmf\controller\RestBaseController;

class IndexController extends RestBaseController
{

    /**
     * @OA\Tag(
     *     name="portal",
     *     description="ThinkCMF企业门户"
     * )
     */
    public function index()
    {
        $this->success('请求成功!', "portal api");
    }

}
