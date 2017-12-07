<?php
use Component\Controller\BaseController;
use Component\DB\MySqlBase;
use Component\ConfigLoader;

use Vendor\Blade\Filesystem;

class MyDbController extends BaseController
{
    public function beforeAction()
    {
    }

    public function afterAction()
    {

    }

    public function doTaskAction()
    {
        $db_config = ConfigLoader::getConfig("MYSQL");
        $db_config = $db_config['DEFAULT'];
        $DB = new MySqlBase($db_config['DB_HOST'], $db_config['DB_NAME'], $db_config['DB_USER'], $db_config['DB_PASSPORT']);
        #$DB->setDebug();

        $DB->beginTransaction();
        $rows = $DB->query("delete from user");
        $DB->commit();

        $rows = $DB->query("insert user set uid=?,nickname=?,addtime=?",array(51,"gg",date("Ymd H:i:s")));
        $rows = $DB->getOne("SELECT * FROM user WHERE uid = ? ", array(51));
        var_dump($rows);
    }
}


