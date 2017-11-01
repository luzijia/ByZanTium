<?php
namespace Component\View;

class View extends \Component\View\ViewInterfce
{
    protected $filePath = '';

    public function assign($key,$value)
    {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*/i', $key)) {
            throw new \Exception('view variable ' . $key . ' name error');
        }
        if (is_array($value)) {
            array_walk_recursive($value, function (&$item, $key) {
                if (is_string($item)) {
                    $item = htmlspecialchars($item);
                }
            });
        } elseif (is_string($value)) {
            $value = htmlspecialchars($value);
        }

        $this->set($key,$value);
    }

    public function render($tpl)
    {
        if($this->datas) extract($this->datas);
        $path = explode(".",$tpl);
        $file = PRJ_PATH.'app/views/'.$path[0].'/'.$path[1].".tpl.php";
        ob_start();
        include $file;
        ob_end_flush();
        return ob_get_contents();

    }

    public function json($data)
    {
        return json_encode($data);
    }

}

