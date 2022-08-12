<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------

namespace app\portal;

use think\facade\Config;
use think\facade\Db;

class PortalApp
{

    // 应用安装
    public function install()
    {
        $appDbSqlFile = CMF_ROOT . "app/portal/data/portal.sql";
        if (file_exists($appDbSqlFile)) {
            $dbConfig = config('database.connections.mysql');
            $sqlList  = cmf_split_sql($appDbSqlFile, $dbConfig['prefix'], $dbConfig['charset']);
            $db       = Db::connect();
            $db->startTrans();
            try {
                foreach ($sqlList as $sql) {
                    $db->execute($sql);
                }
            } catch (\Exception $e) {
                $db->rollback();
                return false;
            }

            return true;
        }

        return false; //安装成功返回true，失败false
    }

    // 应用卸载
    public function uninstall()
    {
        $database  = Config::get('database.connections.' . Config::get('database.default'));
        $prefix    = $database['prefix'];
        $postCount = db('portal_post')->count();
        if ($postCount > 2) {
            return "请先清空所有文章或页面数据,再卸载！";
        }

        Db::execute("drop table {$prefix}portal_category");
        Db::execute("drop table {$prefix}portal_category_post");
        Db::execute("drop table {$prefix}portal_post");
        Db::execute("drop table {$prefix}portal_tag");
        Db::execute("drop table {$prefix}portal_tag_post");
        return true; //卸载成功返回true，失败false
    }

}
