<?php declare(strict_types = 1);

namespace OptimyTest\Helpers;

/**
 * CliRequest class
 */
class Config
{
    const CONFIG_PATH = __DIR__ . '/../../config/';

    /**
     * Get the config
     *
     * @param  string $type
     * @param  string $key
     * @return mixed
     */
    public static function get($type, $key = null) : mixed
    {
        $configs = include(self::CONFIG_PATH . $type . '.php');

        if ($key) {
            return isset($configs[$key]) ? $configs[$key] : null;
        } else {
            return $configs;
        }
    }
}