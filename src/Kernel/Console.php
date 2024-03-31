<?php declare(strict_types = 1);

namespace OptimyTest\Kernel;

use OptimyTest\Requests\ConsoleRequest;

/**
 * Console kernel class
 */
class Console extends AbstractKernel
{
    /**
     * @inheritDoc
     */
    public function initialize($arguments)
    {
        $this->request = new ConsoleRequest(
            $_GET,
            $_POST,
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );

        $this->request->initializeCli($arguments);
    }
}