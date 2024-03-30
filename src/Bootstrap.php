<?php ///declare(strict_types = 1);

namespace OptimyTest;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Handlers/ErrorHandler.php';
require __DIR__ . '/Helpers/Config.php';
require __DIR__ . '/Helpers/SqlFileReader.php';
require __DIR__ . '/Providers/RouteProvider.php';
require __DIR__ . '/Traits/CommentExistTrait.php';
require __DIR__ . '/Traits/NewsExistTrait.php';
require __DIR__ . '/Bootstrap/AbstractBootstrap.php';
require __DIR__ . '/Bootstrap/BootstrapFactory.php';
require __DIR__ . '/Bootstrap/CliBootstrap.php';
require __DIR__ . '/Bootstrap/HttpBootstrap.php';
require __DIR__ . '/Controllers/BaseController.php';
require __DIR__ . '/Controllers/CommentController.php';
require __DIR__ . '/Controllers/DatabaseController.php';
require __DIR__ . '/Controllers/NewsController.php';
require __DIR__ . '/Database/Database.php';
require __DIR__ . '/Database/Query.php';
require __DIR__ . '/Models/BaseModel.php';
require __DIR__ . '/Models/Comment.php';
require __DIR__ . '/Models/News.php';
require __DIR__ . '/Requests/CliRequest.php';

use OptimyTest\Bootstrap\BootstrapFactory;

error_reporting(E_ALL);

/**
 * Initialize the proper request CLI|HTTP
 */
if (php_sapi_name() == 'cli') {
    $settings = include(__DIR__ . '/../bootstrap/cli.php');
    // Add the arguments to $_GET in include it in the  request
    parse_str(implode('&', array_slice($settings['arguments'], 2)), $_GET);
} else {
    $settings = include(__DIR__ . '/../bootstrap/http.php');
}

$bootstrap = BootstrapFactory::get($settings);
$bootstrap->render();