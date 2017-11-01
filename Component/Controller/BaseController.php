<?php
namespace Component\Controller;
abstract class BaseController
{
    protected $Params = [];
    protected $Post   = [];
    protected $view   = '';
    protected $request = '';

    abstract function beforeAction();
    abstract function afterAction();

    public function setRequest(\Component\Http\Request $request)
    {
        $this->request = $request;
    }

    protected function getQuery($key)
    {
        return $this->request->query->get($key);
    }

    protected function getPost($key)
    {
        return $this->request->post->get($key);
    }

    public function setView(\Component\View\View $view)
    {
        $this->view = $view;
    }

    public function assign($key,$value)
    {
        $this->view->assign($key,$value);
    }

    public function render($tpl)
    {
        return $this->view->render($tpl);
        //return new \Component\Http\Response($content);
    }

    public function toJson($data)
    {
        //return new \Component\Http\Response($data)->toJson();
    }
}
