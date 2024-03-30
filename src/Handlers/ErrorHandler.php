<?php declare(strict_types = 1);

namespace OptimyTest\Handlers;

use OptimyTest\Helpers\Config;

/**
 * Error handler class
 */
class ErrorHandler
{
    /**
     * Initialize the error handler
     */
    public function initialize()
    {
        $environment = Config::get('app', 'environment');

        /**
        * Register the error handler
        */
        $whoops = new \Whoops\Run;
        if ($environment !== 'production') {
            $whoops->pushHandler(function($e) {
                echo "An error occured.\n" . $e->getMessage() . "\n";
                // For debugging purposes, we can throw the error to show the call trace.
                // throw $e;
            });
        } else {
            $whoops->pushHandler(function($e) {
                // We are not supporting production right now
            });
        }
        $whoops->register();
    }
}