<?php declare(strict_types = 1);

use Takoma\Lizy\Debug;
use Takoma\Lizy\Lizy;
use Takoma\Template\Api\Root;

// autoloader de Composer
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Lizy::set(dirname(__DIR__));

try {
    Root::set();
} catch (Throwable $e) {
    Debug::get($e)->log();
}
