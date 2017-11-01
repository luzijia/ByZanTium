<?php
namespace Component\Http;
use Component\ContainerInterface;

class Parameters implements ContainerInterface
{
    protected $datas = array();

    public function set($key,$value)
    {
        $this->datas[$key] = $value;
    }

    public function get($key,$default=null)
    {
        return isset($this->datas[$key])?$this->datas[$key]:$default;
    }

    public function has($key)
    {
        return isset($this->datas[$key])?true:false;
    }

    public function getAll()
    {
        return $this->datas;
    }

    public function getKeys()
    {
        return array_keys($this->datas);
    }
}
