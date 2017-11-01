<?php
namespace Component\Http;
/**
 * RFC 3986
 * http://wiki.jabbercn.org/RFC3986
 */

class URI
{
    private $scheme    = null;
    private $authority = array();
    private $path      = null;
    private $query     = null;
    private $method    = 'GET';
    private $headers   = null;
	private $fragment  = '';

    public function __construct()
    {
            $this->scheme    = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';

            $this->authority = array("user"=>(isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : ''),"password"=>isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '');

            if ((isset($_SERVER[$tmp = 'HTTP_HOST']) || isset($_SERVER[$tmp = 'SERVER_NAME'])))
            {
                $this->authority['host'] = $_SERVER[$tmp];

            }else{
                $this->authority['host'] = '';//is a bug?
            }

            if(isset($_SERVER['SERVER_PORT']))
            {
                $this->authority['port'] = $_SERVER['SERVER_PORT'];
            }else{
                $this->authority['port'] = 80; //default port
            }

			foreach ($_SERVER as $key => $value) {
				if (0 === strpos($key, 'HTTP_')) {
					$headers[substr($key, 5)] = $value;
				}
				elseif (isset($contentHeaders[$key])) {
					$headers[$key] = $value;
				}
			}

			$this->headers  = $headers;

			$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
			if ($method === 'POST' && isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])
				&& preg_match('#^[A-Z]+\z#', $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])
			) {
				$method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
			}

			$this->method   = $method;

            $requestUrl     = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

            $requestUrlPart = explode('?', $requestUrl, 2);

            $this->path     = $requestUrlPart[0];

            $this->query    = $requestUrlPart[1];
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getAbsoluteUrl()
    {
return $this->getHostUrl().$this->path.(($tmp = $this->getQuery()) ? '?'.$tmp :'').($this->fragment === '' ? '' : '#' . $this->fragment);
    }

	public function getMethod()
	{
		return $this->method;
	}

	public function getHeaders()
	{
		return $this->headers;
	}
    public function getPort()
    {
        return $this->authority['port'];
    }

	public function getHost()
	{
		return $this->authority['host'];
	}
	public function getBaseUrl()
	{
		return $this->getHostUrl() . $this->getPath();
	}

	private function getHostUrl()
	{
		return $this->scheme."://".($this->authority['user']?$this->authority['user'].':':'').($this->authority['password']?$this->authority['password'].'@':'').$this->authority['host'].":".$this->authority['port'];
	}

}
