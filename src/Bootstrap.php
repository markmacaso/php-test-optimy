<?php ///declare(strict_types = 1);

namespace OptimyTest;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Handlers/ErrorHandler.php';
require __DIR__ . '/Helpers/Config.php';
require __DIR__ . '/Helpers/SqlFileReader.php';
require __DIR__ . '/Providers/RouteProvider.php';
require __DIR__ . '/Traits/CommentExistTrait.php';
require __DIR__ . '/Traits/NewsExistTrait.php';
require __DIR__ . '/Kernel/AbstractKernel.php';
require __DIR__ . '/Kernel/KernelFactory.php';
require __DIR__ . '/Kernel/Console.php';
require __DIR__ . '/Kernel/Http.php';
require __DIR__ . '/Controllers/BaseController.php';
require __DIR__ . '/Controllers/CommentController.php';
require __DIR__ . '/Controllers/DatabaseController.php';
require __DIR__ . '/Controllers/NewsController.php';
require __DIR__ . '/Database/Database.php';
require __DIR__ . '/Database/Query.php';
require __DIR__ . '/Models/BaseModel.php';
require __DIR__ . '/Models/Comment.php';
require __DIR__ . '/Models/News.php';
require __DIR__ . '/Requests/ConsoleRequest.php';

use OptimyTest\Helpers\Config;
use OptimyTest\Kernel\KernelFactory;

error_reporting(E_ALL);

$kernels = Config::get('app', 'kernels');

/**
 * Support for http requests by default
 */
$key = 'http';
$arguments = [];

/**
 * Handle cli requests
 */
if (php_sapi_name() == 'cli') {
    $key = 'cli';
    $arguments = $argv;
    // Add the arguments to $_GET in include it in the  request
    parse_str(implode('&', array_slice($arguments, 2)), $_GET);
}

$settings = $kernels[$key];
$settings['arguments'] = $arguments;
$bootstrap = KernelFactory::get($settings);
$bootstrap->render();