<?php
namespace Component\Http;

class Response
{
    protected $content;

    protected $data;

    protected $contentType = 'text/html';

    protected $charset = 'utf-8';

    protected $version;

    protected $statusCode = 200;

    protected $headers = array();

    protected $statusCodes = array
    (
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',

        // 2xx Success

        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',

        // 3xx Redirection

        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        //306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        // 4xx Client Error

        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'There are too many connections from your internet address',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        429 => 'Too Many Requests',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        498 => 'Invalid or expired token',
        499 => 'Client Wait Too Long',

        // 5xx Server Error

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        530 => 'User access denied',
    );

    public function __construct($content = '', $status = 200)
    {
        $this->setContent($content);
        $this->setStatus($status);
        $this->setProtocolVersion('1.1');
    }

    public static function create($content = '', $status = 200)
    {
        return new static($content, $status);
    }

    public function setContent($content)
    {
        $this->content = (string) $content;
        return $this;
    }

    public function getContent()
    {
        echo $this->content;
        exit;
    }

    public function setContentType($contentType, $charset = null)
    {
        $this->contentType = $contentType;

        if ($charset !== null) {
            $this->charset = $charset;
        }

        return $this;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    public function setStatus($statusCode)
    {
        if (isset($this->statusCodes[$statusCode])) {
            $this->statusCode = $statusCode;
        }

        return $this;
    }

    public function getStatus()
    {
        return $this->statusCode;
    }

    public function setProtocolVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function setHeader($name, $value, $replace = true)
    {
        $name = strtolower($name);

        if ($replace === true) {
            $this->headers[$name] = $value;
        } else {
            $headers = isset($this->headers[$name]) ? $this->headers[$name] : '';
            $this->headers[$name] = array_merge($headers, $value);
        }

        return $this;
    }

    public function hasHeader($name)
    {
        return isset($this->headers[strtolower($name)]);
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHeader($name)
    {
        return isset($this->headers[$name]) ? $this->headers[$name] : '';
    }

    public function sendContent()
    {
        $this->content = (string) $this->content;

        echo $this->content;

        return $this;
    }

    public function isInvalidStatusCode()
    {
        return $this->statusCode < 100 || $this->statusCode >= 600;
    }

    public function isSuccessful()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function isRedirection()
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    public function send()
    {
        if (ob_get_level() === 0) {
            ob_start();
        }

        $this->sendHeaders();
        $this->sendContent();

        ob_end_flush();

        return $this;
    }

	public function sendHeaders()
	{
		// headers have already been send by the developer
		$headersList = headers_list();
		if (!empty($headersList)) {
			return $this;
		}

		header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusCodes[$this->statusCode]), true, $this->statusCode);

		$contentType = $this->contentType;

		if(stripos($contentType, 'text/') === 0 || in_array($contentType, array('application/json', 'application/xml'))) {
			$contentType .= '; charset=' . $this->charset;
		}

		header('Content-Type: ' . $contentType);

		foreach($this->headers as $name => $headers) {
			if (!is_array($headers)) {
				$headers = array($headers);
			}
			foreach($headers as $value) {
				header($name . ': ' . $value, false, $this->statusCode);
			}
		}
		return $this;
	}

    private function getData()
    {
        return $this->data;
    }

    public function toJson($data)
    {
        $this->data = json_encode($data);
        $this->setContentType('application/json');
        echo $this->send()->getData();exit;
    }
}
