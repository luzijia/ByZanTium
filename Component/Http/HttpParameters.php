<?php
namespace Component\Http;
use Component\Http\Parameters;
class HttpParameters extends Parameters
{
    public function __construct($datas)
    {
        $this->datas = $datas;
        array_walk_recursive($this->datas,array($this,"array_recursive"));
    }

    private function array_recursive(&$value,$key)
    {
       $value = addslashes($value);
       $key   = addslashes($key);
    }
}
