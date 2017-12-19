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
                    $fn = str_replace($pkey,$pvalue['autoload_src'],$class).".php";

                    self::registerClass($fn);
                }

                if(isset($pvalue['autoload_files'])){
                    self::import($pvalue['autoload_files']);
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

    private static function loadComposer()
    {
        $AppComposerFileName = ROOT_PATH."ByZanTium/Vendor/composer/autoload_composer.php";
        $PrjComposerFileName = PRJ_PATH."app/vendor/composer/autoload_composer.php";
        return array_merge(self::import($AppComposerFileName),self::import($PrjComposerFileName));
    }

    public static function import($filename)
    {
        return file_exists($filename)?include $filename:[];
    }
}
