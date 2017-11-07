<?php
namespace FrameWork;

abstract class Base
{
    protected $appName = '';

    protected $moduleName     = '';

    protected $controllerName = '';

    protected $actionName     = '';

    protected $params         = [];

    protected $router         = '';

    protected $request        = '';

    protected $view           = '';

    protected $layout         = '';

    protected $route          = '';

    abstract public function run();

    public function __construct($_appName)
    {
        $this->appName = $_appName;

        $this->route   = new \Component\Router\Route();
    }

    public function setRouter(\Component\Router\Router $_router)
    {
        $this->router = $_router;
    }

    public function setRequest(\Component\Http\Request $_request)
    {
        $this->request = $_request;
    }

    public function setView(\Component\View\ViewInterfce $_view)
    {
        $this->view = $_view;
    }

    public function getController()
    {
        #todo default Controller and Action
        $moduleName     = $this->router->moduleName;
        $controllerName = ucfirst($this->router->controllerName)."Controller";
        if($this->router->moduleName){
           $controllerName='\\'.$this->router->moduleName.'\\'.$controllerName;
        }
        $ins = new $controllerName();
        return $ins;
    }

    public function getActionName()
    {
        return ucfirst($this->router->actionName)."Action";
    }
}
