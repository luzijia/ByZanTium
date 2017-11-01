<?php
namespace Component;
/*
 *
 * ContainerInterface is a container for key/value pairs
 *
 */
interface ContainerInterface
{
    public function set($key,$value);

    public function get($key,$default=null);

    public function has($key);
}
