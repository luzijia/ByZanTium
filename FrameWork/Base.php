<?php
namespace FrameWork;

abstract class Base
{
    protected $appName = '';

    protected $controllerName = '';

    protected $actionName     = '';

    protected $params         = [];

    protected $router         = '';

    protected $request        = '';

    protected $view           = '';

    protected $layout         = '';

    abstract public function run();

    public function __construct($_appName)
    {
        $this->appName = $_appName;
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
        $controllerName = ucfirst($this->router->controllerName)."Controller";
        if($controllerName=='ApiController'){
            //how to add $moduleName router???
            $controllerName='\\api\\'.$controllerName;
        }
        $ins = new $controllerName();
        return $ins;
    }

    public function getActionName()
    {
        return ucfirst($this->router->actionName)."Action";
    }
}
