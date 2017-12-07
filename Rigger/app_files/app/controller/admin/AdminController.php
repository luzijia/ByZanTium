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
    public function WelcomeAction()
    {
        $this->display('Admin.admin');
    }
    public function getVideoListAction()
    {
        $this->assign("page",$this->getQuery("page"));
        $this->assign("cate",$this->getQuery("cate"));
        $this->display('hello');
    }
    public function afterAction()
    {

    }
}
