<?php
class App
{
	public static function run(\FrameWork\Base $container)
	{
		try{
            self::initConfig();
			$container->run();
		}catch(\Exception $e)
		{
			echo $e->getMessage();
		}
	}

    private function initConfig()
    {

        $prjConfig = \AutoLoad::import(PRJ_PATH."config/config.php");

        $appConfig = \AutoLoad::import(ROOT_PATH."ByZanTium/Config/AppConfig.php");

        $config    = array_replace_recursive($appConfig,$prjConfig);

        date_default_timezone_set($config['TIMEZONE']);

        mb_internal_encoding($config['CHARSET']);

        \Component\ConfigLoader::initConfig($config);

        set_exception_handler(function($exception){
            echo "OPPS...";
            echo $exception->getMessage();
            echo "\n";
        });

    }
}
