<?php
class AutoLoad
{
    public static function initAutoLoader()
    {
        spl_autoload_register(function($class){

            $class_map =[];

            $class_map['WebDefaultIndexController'] = ROOT_PATH.'ByZanTium/Component/Controller/WebDefaultIndexController.php';
            $class_map['TaskDefaultIndexController'] = ROOT_PATH.'ByZanTium/Component/Controller/TaskDefaultIndexController.php';

            $POSTFIX_DIR_Array = array(
                ROOT_PATH."ByZanTium",
                PRJ_PATH."cli",
                PRJ_PATH."app/controller",
                PRJ_PATH."app/models",
                PRJ_PATH."app/service",
                PRJ_PATH."app/views",
            );

            if(isset($class_map[$class])){
                $class = $class_map[$class];
                include $class;
                return true;
            }

            $composer_class = self::loadComposer();

            foreach($composer_class as $pkey=>$pvalue)
            {
                if(strpos($class,$pkey)!==false)
                {
                    $fn = str_replace($pkey,$pvalue,$class).".php";

                    self::registerClass($fn);
                }
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

    private function loadComposer()
    {
        $filename = ROOT_PATH."ByZanTium/Vendor/composer/autoload_composer.php";
        return self::import($filename);
    }

    public static function import($filename)
    {
        return file_exists($filename)?include $filename:[];
    }
}
