<?php declare(strict_types = 1);

namespace OptimyTest\Controllers;

use OptimyTest\Database\Database;
use OptimyTest\Helpers\Config;
use OptimyTest\Helpers\SqlFileReader;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class that handle database related actions
 */
class DatabaseController extends BaseController
{
    /**
     * Run initial database sql
     *
     * @param  Request $request
     * @return string
     */
    public function init(Request $request)
    {
        $initialFile = Config::get('database', 'initial');
        $sql = SqlFileReader::get($initialFile);
        $database = Database::getInstance();
        $database->exec($sql);
        return $this->text('Successfully initialized database');
    }
}