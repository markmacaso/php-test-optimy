<?php declare(strict_types = 1);

namespace OptimyTest\Kernel;

use FastRoute\Dispatcher;
use OptimyTest\Handlers\ErrorHandler;
use OptimyTest\Providers\RouteProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Bootstrap provider class
 */
abstract class AbstractKernel
{
    /**
     * @var RouteProvider
     */
    protected RouteProvider $routeProvider;
    /**
     * @var ErrorHandler
     */
    protected ErrorHandler $errorHandler;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Environment
     */
    protected Environment $templater;

    /**
     * @var string
     */
    protected string $templateFolderName = 'views';

    /**
     * Initialize the bootstrap
     *
     * @param array $arguments
     */
    abstract public function initialize($arguments);

    /**
     * Class constructor
     *
     * @param Environment $templater
     * @param RouteProvider $routeProvider
     * @param ErrorHandler $errorHandler
     * @param array $arguments
     */
    public function __construct(
        Environment $templater,
        RouteProvider $routeProvider,
        ErrorHandler $errorHandler,
        array $arguments
    )
    {
        $this->templater = $templater;
        $this->errorHandler = $errorHandler;
        $this->routeProvider = $routeProvider;

        $this->initialize($arguments);
    }

    /**
     * Render the request response
     */
    public function render()
    {
        $routeInfo = $this->routeProvider->getRouteInfo($this->request);

        /**
         * Initialize response
         */
        $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        /**
         * Render the correct view
         */
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $response->setContent('404 - Page not found');
                $response->setStatusCode(404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $response->setContent('405 - Method not allowed');
                $response->setStatusCode(405);
                break;
            case Dispatcher::FOUND:
                $className = $routeInfo[1][0];
                $method = $routeInfo[1][1];
                $vars = $routeInfo[2];

                $class = new $className;
                $class->setTemplater($this->templater);
                $result = $class->$method($this->request, $vars);

                echo $result;
                break;
        }
    }
}