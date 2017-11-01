<?php
date_default_timezone_set("Asia/Shanghai");
mb_internal_encoding("UTF-8");

class App
{
	public static function run(\FrameWork\Base $container)
	{
		try{
			$container->run();
		}catch(\Exception $e)
		{
            //todo default page or json data
			echo $e->getMessage();
		}
	}

}
