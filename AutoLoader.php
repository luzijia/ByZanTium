<?php
class AutoLoad
{
    public static function initAutoLoader()
    {
        spl_autoload_register(function($class){

            $POSTFIX_DIR_Array = array(
                ROOT_PATH."ByZanTium",
                ROOT_PATH."ByZanTium/Component/Controller",
                PRJ_PATH."app/controller",
                PRJ_PATH."app/models",
                PRJ_PATH."app/service",
                PRJ_PATH."app/views",
                PRJ_PATH."cli",
            );

            foreach($POSTFIX_DIR_Array as $POSTFIX_DIR)
            {

                $class = str_replace('\\', '/', $class);

                $fn    = $POSTFIX_DIR.DIRECTORY_SEPARATOR.$class.".php";

                #echo $fn."<br />";

                if (file_exists($fn))
                {
                    require_once $fn;
                    return true;
                }
            }

            return false;

        });
    }
}
