<?php declare(strict_types = 1);

namespace OptimyTest\Bootstrap;

use OptimyTest\Requests\CliRequest;

/**
 * Bootstrap provider class
 */
class CliBootstrap extends AbstractBootstrap
{
    /**
     * @inheritDoc
     */
    public function initialize($arguments)
    {
        $this->request = new CliRequest(
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