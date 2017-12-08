<?php
use Component\Controller\BaseController;
use Component\DB\MySqlBase;
use Component\ConfigLoader;

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

        $rows = $DB->getOne("SELECT * FROM user WHERE uid = ? ", array(51));
        var_dump($rows);
    }
}


