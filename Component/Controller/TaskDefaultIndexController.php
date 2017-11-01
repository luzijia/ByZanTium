<?php
class TaskDefaultIndexController extends \Component\Controller\BaseController
{
    public function beforeAction()
    {
        echo "welcome DEFAULT TASK CONTROLLER!\n";
    }
    public function doHelloWorld()
    {
        echo "say Hello World!\n";
    }
    public function afterAction()
    {

        echo "GOOD BYE!\n";
    }

}


