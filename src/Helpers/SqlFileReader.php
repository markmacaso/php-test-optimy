<?php declare(strict_types = 1);

namespace OptimyTest\Helpers;

/**
 * CliRequest class
 */
class SqlFileReader
{
    const SQL_PATH = __DIR__ . '/../../database/';

    /**
     * Read the content of an sql file
     *
     * @param  string $name
     * @return string
     */
    public static function get($name) : mixed
    {
        return file_get_contents(self::SQL_PATH . $name . '.sql');
    }
}