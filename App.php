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
			echo $e->getMessage();
		}
	}
}
