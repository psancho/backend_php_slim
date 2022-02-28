<?php declare(strict_types=1);

use Takoma\Lizy\Provider\LogProvider;
use Takoma\Template\Api\Provider\SlimProvider;

require '../src/bootStrap.php';

try {
    SlimProvider::init();

} catch (Throwable $e) {
    LogProvider::error($e);
}
