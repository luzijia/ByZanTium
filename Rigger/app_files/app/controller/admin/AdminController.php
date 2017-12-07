<?php
namespace admin;
class AdminController extends \Component\Controller\BaseController
{
    public function __construct()
    {
    }
    public function beforeAction()
    {
    }
    public function DetailAction()
    {
        $this->display('Admin.admin');
    }
    public function afterAction()
    {

    }
}
