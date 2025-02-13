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
    namespace app\portal\model;

    use think\Model;

    class AccountsModel extends Model
    {

        /**
         * 模型名称
         * @var string
         */
        protected $name = 'Accounts';
        protected $connection = 'sqlsrv';

        public function getAll(){
            return $this->field(['AccountName','RegisterDate','NxLoginPwd'])
                ->limit(10)->select();
        }


    }