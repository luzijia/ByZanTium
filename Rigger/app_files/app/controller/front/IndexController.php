<?php
namespace front;
class IndexController extends \Component\Controller\BaseController
{
	public function indexAction()
	{
		$dataArr = ["errno"=>0,"msg"=>"welcome","params"=>$this->getQuery('x')];
        $this->assign("data",$dataArr);
        $this->display('Front.front');
   }
    public function createAction()
    {

    }
    public function beforeAction()
    {

    }

    public function afterAction()
    {

    }

}

