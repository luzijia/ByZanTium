<?php
class AutoLoad
{
    public static function initAutoLoader()
    {
        self::loadComposer();

        spl_autoload_register(function($class){

            $class_map =[];

            $class_map['WebDefaultIndexController'] = ROOT_PATH.'ByZanTium/Component/Controller/WebDefaultIndexController.php';
            $class_map['TaskDefaultIndexController'] = ROOT_PATH.'ByZanTium/Component/Controller/TaskDefaultIndexController.php';

            $POSTFIX_DIR_Array = array(
                ROOT_PATH."ByZanTium",
                PRJ_PATH."app",
                PRJ_PATH."cli",
                PRJ_PATH."app/controller",
            );

            if(isset($class_map[$class])){
                $class = $class_map[$class];
                include $class;
                return true;
            }

            foreach($POSTFIX_DIR_Array as $POSTFIX_DIR)
            {

                $class = str_replace('\\', '/', $class);

                $fn    = $POSTFIX_DIR.DIRECTORY_SEPARATOR.$class.".php";

                self::registerClass($fn);

            }

            return false;

        });
    }

    private static function registerClass($fn)
    {
        $fn = str_replace("\\","/",$fn);
        if (file_exists($fn))
        {
            require_once $fn;
            return true;
        }

    }

    private static function loadComposer()
    {
         $composerFile = PRJ_PATH."vendor/autoload.php";
         if(is_file($composerFile))
         {
                self::import($composerFile);
         }
         return false;

    }

    public static function import($filename)
    {
        return file_exists($filename)?include $filename:[];
    }
}
