<?php declare(strict_types = 1);

use Takoma\Lizy\Debug;
use Takoma\Template\Api\Provider\RestApiProvider;

require '../src/bootStrap.php';

try {
    RestApiProvider::init();

} catch (Throwable $e) {
    Debug::get($e)->log();
}
