<?php

namespace Component\View;

use Vendor\Blade\FileViewFinder;
use Vendor\Blade\Factory;
use Vendor\Blade\Compilers\BladeCompiler;
use Vendor\Blade\Engines\CompilerEngine;
use Vendor\Blade\Filesystem;
use Vendor\Blade\Engines\EngineResolver;


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
        $path = explode(".",$tpl);

        if(count($path)>1){
            $tpl_path = [PRJ_PATH.'app/views/'.$path[0]."/"];
            $tpl_name = $path[1];
        }else{
            $tpl_path = [PRJ_PATH.'app/views/'];
            $tpl_name = $path[0];
        }
        $cachePath = \Component\ConfigLoader::getConfig("CACHE_DIR");

        $file     = new Filesystem;
        $compiler = new BladeCompiler($file, $cachePath);

        /*
        $compiler->directive('datetime', function($timestamp) {
            return preg_replace('/(\(\d+\))/', '<?php echo date("Y-m-d H:i:s", $1); ?>', $timestamp);
        });*/

        $resolver = new EngineResolver;
        $resolver->register('blade', function () use ($compiler) {
            return new CompilerEngine($compiler);
        });

        $factory = new Factory($resolver, new FileViewFinder($file, $tpl_path));

        $factory->addExtension('tpl', 'blade');

        return $factory->make($tpl_name,$this->datas)->render();
    }

    public function json($data)
    {
        return json_encode($data);
    }

}

