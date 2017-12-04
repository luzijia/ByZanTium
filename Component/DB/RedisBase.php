<?php
namespace Component\DB;

class RedisProxy
{
	private $_redis = null;

	private function __construct($config)
	{
        return $this->getRedis($config);
	}

	/**
	 * @param null $config
	 * @return Redis
	 */
	public static function getInstance($config = null)
	{
		try {
			static $ins;
			$key = $config ? md5(serialize($config)) : "default";
			if(isset($ins[$key]) && $ins[$key] instanceof Redis && $ins[$key]->ping() == "+PONG"){
				return $ins[$key];
			}
			$ins[$key] = new self($config);
			if(empty($ins[$key]->_redis)){
				return false;
			}
			return $ins[$key];
		} catch(Exception $e) {
			$log_message = array(
				'error_code' => $e->getCode(),
				'error_message' => $e->getMessage(),
				'error_trace' => $e->getTraceAsString(),
				'config' => $config,
			);
		}
		return false;
	}

	private function getRedis($config = null)
	{
		if(!$config) {
			#$config = SimpleConfig::get("DISK_REDIS_CONF");
            return false;
		}

		try {
			$redis = $this->_getRedisHandler($config);
			if (!$redis) {
                return false;
			}
		} catch(Exception $e) {
			$log_message = array(
				'error_code' => $e->getCode(),
				'error_message' => $e->getMessage(),
				'error_trace' => $e->getTraceAsString(),
				'config' => $config,
			);
			return false;
		}

		return $redis;
	}

	public function __call($name, $arguments)
	{
		try {
			return call_user_func_array(array($this->_redis, $name), $arguments);
		} catch(Exception $e) {
			$log_message = array(
				'error_code' => $e->getCode(),
				'error_message' => $e->getMessage(),
				'error_trace' => $e->getTraceAsString()
			);
		}
		return false;
	}

	public function __destruct()
	{
		if($this->_redis instanceof Redis){
			$this->_redis->close();
		}else{
			$this->_redis = null;
		}
	}

	private function _getRedisHandler($config,$times = 3,$timeout = 0.5)
	{
		do {
			if(isset($config["timeout"])) {
				$timeout = $config["timeout"];
			}
			$redis  = new Redis();
			$redis->connect($config["host"], $config["port"], $timeout);
			$redis->auth($config["password"]);

			if (!empty($redis)) {
				return $redis;
			}
		} while ($times--);
		return false;
	}
}
