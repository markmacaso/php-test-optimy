<?php declare(strict_types = 1);

namespace OptimyTest\Bootstrap;

use Symfony\Component\HttpFoundation\Request;

/**
 * Bootstrap provider class
 */
class HttpBootstrap extends AbstractBootstrap
{
    /**
     * @inheritDoc
     */
    public function initialize($arguments)
    {
        $this->request = new Request(
            $_GET,
            $_POST,
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
    }
}