<?php declare(strict_types = 1);

namespace OptimyTest\Kernel;

use OptimyTest\Handlers\ErrorHandler;
use OptimyTest\Providers\RouteProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Bootstrap factory class
 */
class KernelFactory
{
    /**
     * Get the bootstrap
     *
     * @param  array $settings
     * @return AbstractKernel
     */
    public static function get($settings)
    {
        /**
         * Initialize path to needed files
         */
        $templates = __DIR__ . "/../Resources/" . $settings['templates'];
        $routes = __DIR__ . "/../../routes/" . $settings['routes'] . '.php';

        /**
         * Initialize the error handler
         */
        $errorHandler = new ErrorHandler();
        $errorHandler->initialize();

        /**
         * Initialize the route provider
         */
        $routeProvider = new RouteProvider();
        $routeProvider->initialize($routes);

        /**
         * Initialize templater (twig)
         */
        $loader = new FilesystemLoader($templates);
        $templater = new Environment(
            $loader,
            [
                //'cache' => __DIR__ . '/../cache/views',
                'auto_reload' => true,
                'cache' => false
            ]
        );

        $kernel = new $settings['class'](
            $templater,
            $routeProvider,
            $errorHandler,
            $settings['arguments']
        );

        return $kernel;
    }
}