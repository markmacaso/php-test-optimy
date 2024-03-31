<?php declare(strict_types = 1);

namespace OptimyTest\Requests;

use Symfony\Component\HttpFoundation\Request;

/**
 * CliRequest class
 */
class ConsoleRequest extends Request
{
    /**
     * Initialize cli request
     *
     * @param  array $arguments
     * @return ConsoleRequest
     */
    public function initializeCli($arguments) : ConsoleRequest
    {
        $action = isset($arguments[1]) ? $arguments[1] : '--';

        if (substr($action, 0, 2) !== '--') {
            throw new \Exception('Invalid action');
        }

        $action = substr($action, 2);
        $this->pathInfo = $action;
        $this->setMethod('CLI');

        return $this;
    }
}