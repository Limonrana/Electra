<?php

namespace Illumine\Http;

class Response
{
    /**
     * The response status code.
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * The response headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * The response content.
     *
     * @var string
     */
    protected $content = '';

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return void
     */
    public function __construct($content = '', $status = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $status;
        $this->headers = $headers;
    }

    /**
     * Get the response status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the response status code.
     *
     * @param  int  $status
     * @return $this
     */
    public function setStatusCode($status)
    {
        $this->statusCode = $status;
        http_response_code($status);

        return $this;
    }

    /**
     * Get the response headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the response headers.
     *
     * @param  array  $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get the response content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the response content.
     *
     * @param  string  $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Send the response.
     *
     * @return void
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    /**
     * Send the response headers.
     *
     * @return void
     */
    protected function sendHeaders()
    {
        foreach ($this->headers as $name => $value) {
            header($name.': '.$value, true);
        }
    }

    /**
     * Send the response content.
     *
     * @return void
     */
    protected function sendContent()
    {
        echo $this->content;
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function make($content = '', $status = 200, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function create($content = '', $status = 200, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function json($content = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'application/json';

        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function xml($content = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'application/xml';

        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function html($content = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'text/html';

        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function text($content = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'text/plain';

        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function csv($content = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'text/csv';

        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function download($content = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'application/octet-stream';

        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function stream($content = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'application/octet-stream';

        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function redirect($content = '', $status = 302, array $headers = [])
    {
        $headers['Location'] = $content;

        return new static('', $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function back($content = '', $status = 302, array $headers = [])
    {
        $headers['Location'] = 'javascript:history.back()';

        return new static('', $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function refresh($content = '', $status = 302, array $headers = [])
    {
        $headers['Location'] = 'javascript:history.refresh()';

        return new static('', $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function abort($content = '', $status = 500, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function error($content = '', $status = 500, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function forbidden($content = '', $status = 403, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function notFound($content = '', $status = 404, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function methodNotAllowed($content = '', $status = 405, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function notAcceptable($content = '', $status = 406, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function unprocessable($content = '', $status = 422, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function serverError($content = '', $status = 500, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function created($content = '', $status = 201, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function accepted($content = '', $status = 202, array $headers = [])
    {
        return new static($content, $status, $headers);
    }


    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function noContent($content = '', $status = 204, array $headers = [])
    {
        return new static($content, $status, $headers);
    }


    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function movedPermanently($content = '', $status = 301, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function found($content = '', $status = 302, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function seeOther($content = '', $status = 303, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function temporaryRedirect($content = '', $status = 307, array $headers = [])
    {
        return new static($content, $status, $headers);
    }


    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function badRequest($content = '', $status = 400, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function unauthorized($content = '', $status = 401, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

    /**
     * Create a new response instance.
     *
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     * @return static
     */
    public static function paymentRequired($content = '', $status = 402, array $headers = [])
    {
        return new static($content, $status, $headers);
    }

}