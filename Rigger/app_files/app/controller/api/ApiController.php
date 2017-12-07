<?php
namespace api;
class ApiController extends \Component\Controller\BaseController
{
    public function __construct()
    {
    }
    public function beforeAction()
    {

    }
    public function DetailAction()
    {
        $this->display('Api.api');

    }
    public function afterAction()
    {

    }

}
