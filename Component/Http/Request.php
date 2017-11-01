<?php
namespace Component\Http;
use Component\Http\URI;
use Component\Http\HttpParameters;
class Request
{
    public $uri;
    public $query;
    public $post;

    public static function makeRequest()
    {
            return new static();
    }

    public function __construct()
    {
        $this->uri     = new URI();
        $this->query   = new HttpParameters($_GET);
        $this->post    = new HttpParameters($_POST);
    }
}
