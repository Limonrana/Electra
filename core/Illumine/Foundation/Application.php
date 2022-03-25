<?php

namespace Illumine\Foundation;

use Illumine\Http\Request;
use Illumine\Http\Response;
use Illumine\Routing\Router;

class Application
{
    /**
     * The Illumine application base path.
     *
     * @return string|null  $basePath
     */
    public static string|null $BASE_PATH;

    /**
     * The Illumine application environment.
     *
     * @return string|null  $environment
     */
    public static string|null $ENVIRONMENT;

    /**
     * The Illumine application debug mode.
     *
     * @return bool  $debug
     */
    public static bool $DEBUG;

    /**
     * The Illumine application instance.
     *
     * @return \Illumine\Foundation\Application  $app
     */
    public static Application $app;

    /**
     * The Illumine router instance.
     *
     * @var \Illumine\Routing\Router
     */
    public Router $router;

    /**
     * The Illumine request instance.
     *
     * @var \Illumine\Http\Request
     */
    public Request $request;

    /**
     * The Illumine application instance.
     *
     * @var \Illumine\Http\Response
     */
    public Response $response;

    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct(?string $basePath = null)
    {
        self::$app = $this;
        self::$BASE_PATH = $basePath;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->dispatch();
    }
}