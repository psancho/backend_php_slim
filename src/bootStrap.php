<?php declare(strict_types=1);

use Takoma\Lizy\Lizy;
use Takoma\Lizy\Provider\LogProvider;
use Takoma\Template\Api\Root;

// autoloader de Composer
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Lizy::set(dirname(__DIR__));

try {
    Root::set();
} catch (Throwable $e) {
    LogProvider::error($e);
}
