<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2019 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;

use app\portal\model\AccountsModel;
use cmf\controller\HomeBaseController;
use think\Db;

class IndexController extends HomeBaseController
{
    public function index()
    {
//        $data = Db::connect('sqlsrv')->table('Accounts')->limit(10)->select();
//        $account = new AccountsModel();
//        $info = [
//            'AccountName' => 'jonny',
//            'RegisterDate' => date('Y-m-d H:i:s',time()),
//            'NxLoginPwd' => strtoupper(md5('webswebs')),
//            'AccountLevelCode' => 0,
//            'CharacterCreateLimit' => 6,
//            'PublisherCode' => 4,
//            'CharacterMaxCount' => 6,
//
//        ];
//        $id = $account->insert($info);
//        $data1 = $account->getAll();
//        var_dump($account->getLastSql());die;
        return $this->fetch(':index');
    }
}
