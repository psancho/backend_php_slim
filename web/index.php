<?php declare(strict_types = 1);

use Takoma\Lizy\Debug;
use Takoma\Template\Api\Provider\SlimProvider;

require '../src/bootStrap.php';

try {
    SlimProvider::init();

} catch (Throwable $e) {
    Debug::get($e)->log();
}
