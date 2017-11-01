<?php
class WebDefaultIndexController extends \Component\Controller\BaseController
{
    public function beforeAction()
    {
        echo "welcome DEFAULT WEB CONTROLLER!\n";
    }
    public function sayHelloAction()
    {
        echo "say Hello World!\n";
    }
    public function afterAction()
    {

        echo "GOOD BYE!\n";
    }

}


