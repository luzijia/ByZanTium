<?php
namespace Component\Controller;
abstract class BaseController
{
    protected $view   = '';
    protected $request = '';
    protected $Params = [];

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

    public function setCliParams($Params)
    {
        $this->Params = $Params;
    }

    public function getParams($key)
    {
        return isset($this->Params[$key])?$this->Params[$key]:'';
    }

    public function setView(\Component\View\View $view)
    {
        $this->view = $view;
    }

    public function assign($key,$value)
    {
        $this->view->assign($key,$value);
    }

    public function display($tpl)
    {
        $content = $this->view->render($tpl);
        \Component\Http\Response::create($content)->send();
    }

    public function toJson($data=array())
    {
        \Component\Http\Response::create()->toJson($data);
    }

    public function __call($method,$params)
    {
        $content = "NO $method ! ";
        if($this->request->uri->isAjax()){
            $data = array("errno"=>10001,"msg"=>$content);
            \Component\Http\Response::create()->toJson($data);
        }else{
            \Component\Http\Response::create($content)->send();
        }
    }

}
