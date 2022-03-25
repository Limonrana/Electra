<?php

namespace Illumine\Http;

class Request
{
    /**
     * @var array
     */
    protected $server;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array | object | null
     */
    protected $all;

    /*
     * @var array
     */
    protected $parameters;

    /**
     * @var string
     */
    protected $queryString;

    /**
     * @var array
     */
    protected $queryParameters;

    /**
     * @var array
     */
    protected $bodyParameters;

    /**
     * @var array
     */
    protected $files;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var string
     */
    protected $requestUri;

    /*
     * @var array
     */
    protected $cookies;

    /**
     * @var array
     */
    protected $session;

    /**
     * Create a new Request instance.
     * @return void
     */
    public function __construct()
    {
        $this->setServer();
        $this->setMethod();
        $this->setUri();
        $this->setHeaders();
        $this->setBody();
        $this->setFiles();
        $this->setAttributes();
        $this->setParameters();
        $this->setCookies();
        $this->setHost();
        $this->setPath();
        $this->setQueryString();
        $this->setQueryParameters();
        $this->setRequestUri();
//        $this->setSessions();
    }

    /**
     * Set the server array.
     * @return void
     */
    protected function setServer()
    {
        $this->server = $_SERVER;
    }


    /**
     * Get the request method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the request method.
     *
     * @return $this
     */
    public function setMethod()
    {
        $this->method           = $this->server['REQUEST_METHOD'] ?? 'GET';
        $this->{'method'}       = $this->server['REQUEST_METHOD'] ?? 'GET';
        $this->all['_method']   = $this->server['REQUEST_METHOD'] ?? 'GET';
        return $this;
    }

    /**
     * Get the request URI.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set the request URI.
     *
     * @return $this
     */
    public function setUri()
    {
        $this->uri = $this->server['REQUEST_URI'] ?? '/';
        return $this;
    }

    /**
     * Get the request URI host.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the request URI host.
     *
     * @return $this
     */
    public function setHost()
    {
        $this->host = $this->server['HTTP_HOST'] ?? 'localhost';
        return $this;
    }

    /**
     * Get the request URI path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the request URI path.
     *
     * @return $this
     */
    public function setPath()
    {
        $path = $this->server['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        $this->path = $position ? substr($path, 0, $position) : $path;
        return $this;
    }

    /**
     * Get the request input.
     * @param string $key
     * @param string $default
     * @return string | array | null | integer | boolean | float | object
     */
    public function input(string $key = null, $default = null)
    {
        if ($key) {
            return $this->all[$key] ?? $default;
        }
        return $this->all;
    }

    /**
     * Get the request all.
     *
     * @return array
     */
    public function all()
    {
        return $this->all;
    }


    /**
     * Get the request body.
     *
     * @return array
     */
    public function getBody()
    {
        return $this->all;
    }

    /**
     * Set the request body.
     *
     * @return $this
     */
    public function setBody()
    {
        if ($this->getMethod() == 'POST') {
            foreach ($_POST as $key => $value) {
                $this->all[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        elseif ($this->getMethod() == 'PUT') {
            $this->all['data'] = json_decode(file_get_contents('php://input'), true);
        }
        elseif ($this->getMethod() == 'DELETE') {
            $this->all['data'] = json_decode(file_get_contents('php://input'), true);
        }
        elseif ($this->getMethod() == 'GET') {
            foreach ($_GET as $key => $value) {
                $this->all[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        elseif ($this->getMethod() == 'HEAD') {
            foreach ($_GET as $key => $value) {
                $this->all[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        elseif ($this->getMethod() == 'OPTIONS') {
            foreach ($_GET as $key => $value) {
                $this->all[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        elseif ($this->getMethod() == 'PATCH') {
            $this->all['data'] = json_decode(file_get_contents('php://input'), true);
        }
        return $this;
    }

    /**
     * Get the request headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the request headers.
     *
     * @return $this
     */
    public function setHeaders()
    {
        foreach ($this->server as $name => $value) {
            if (strpos($name, 'HTTP_') === 0) {
                $this->headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $this;
    }

    /**
     * Get the request header.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getHeader($name, $default = null)
    {
        return $this->headers[$name] ?? $default;
    }

    /**
     * Get the request URI request URI.
     *
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * Set the request URI request URI.
     *
     * @return $this
     */
    public function setRequestUri()
    {
        $this->requestUri = $this->server['REQUEST_URI'] ?? '/';
        return $this;
    }

    /**
     * Get the request URI query string.
     *
     * @return string
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * Set the request URI query string.
     *
     * @return $this
     */
    public function setQueryString()
    {
        $this->queryString = $this->server['QUERY_STRING'] ?? '';
        return $this;
    }

    /**
     * Get the request parameter.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getQueryParameter($name, $default = null)
    {
        return $this->queryParameters[$name] ?? $default;
    }

    /**
     * Get the request query parameters.
     *
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    /**
     * Set the request query parameters.
     *
     * @return $this
     */
    public function setQueryParameters()
    {
        parse_str($this->getQueryString(), $this->queryParameters);
        return $this;
    }

    /**
     * Get the request parameter.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getBodyParameter($name, $default = null)
    {
        return $this->bodyParameters[$name] ?? $default;
    }

    /**
     * Get the request body parameters.
     *
     * @return array
     */
    public function getBodyParameters()
    {
        return $this->bodyParameters;
    }

    /**
     * Set the request body parameters.
     *
     * @return $this
     */
    public function setBodyParameters()
    {
        parse_str($this->getBody(), $this->bodyParameters);
        return $this;
    }

    /**
     * Get the request parameter.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getParameter($name, $default = null)
    {
        return $this->parameters[$name] ?? $default;
    }

    /**
     * Get the request parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set the request parameters.
     *
     * @return $this
     */
    public function setParameters()
    {
//        $this->parameters = array_merge($this->getQueryParameters(), $this->getBodyParameters());
        $this->parameters = $this->getQueryParameters();
        return $this;
    }

    /**
     * Has the request file.
     *
     * @param string $name
     * @return boolean
     */
    public function hasFile($name)
    {
        return isset($this->files[$name]['name']) ?? false;
    }

    /**
     * Get the request file.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getFile($name, $default = null)
    {
        return $this->files[$name] ?? $default;
    }

    /**
     * Get the request files.
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set the request files.
     *
     * @return $this
     */
    public function setFiles()
    {
        if (isset($_FILES)) {
            $this->files = $_FILES;
            foreach ($this->files as $key => $value) {
                $this->all[$key]['name'] = $value['name'];
                $this->all[$key]['temp_name'] = $value['tmp_name'];
                $this->all[$key]['size'] = $value['size'];
                $this->all[$key]['type'] = $value['type'];
                $this->all[$key]['error'] = $value['error'];
                $this->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $this;
    }

    /**
     * Get the request attribute.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    /**
     * Get the request attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the request attributes.
     *
     * @return $this
     */
    public function setAttributes()
    {
        $this->attributes = $_REQUEST;
        return $this;
    }

    /**
     * Get the request cookies.
     *
     * @return string
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Set the request cookies.
     *
     * @return $this
     */
    public function setCookies()
    {
        foreach ($_COOKIE as $name => $value) {
            $this->cookies[$name] = $value;
        }
        return $this;
    }

    /**
     * Get the request cookie.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getCookie($name, $default = null)
    {
        return $this->cookies[$name] ?? $default;
    }

    /**
     * Get the request session.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getSession($name, $default = null)
    {
        return $this->session[$name] ?? $default;
    }

    /**
     * Get the request sessions.
     *
     * @return array
     */
    public function getSessions()
    {
        return $this->session;
    }

    /**
     * Set the request sessions.
     *
     * @return $this
     */
    public function setSessions()
    {
//        $this->session = $_SESSION;
        return $this;
    }

    /**
     * Dump the request items and end the script.
     *
     * @param  array|mixed  $keys
     * @return void
     */
    public function dd(...$keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        call_user_func_array([$this, 'dump'], $keys);

        exit(1);
    }

}