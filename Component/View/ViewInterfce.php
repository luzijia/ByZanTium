<?php
namespace Component\View;

abstract class ViewInterfce implements \Component\ContainerInterface
{
    protected $data = [];

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

    abstract public function render($tpl);

    abstract public function assign($key,$value);
}
