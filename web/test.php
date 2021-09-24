<?php declare(strict_types = 1);

use Takoma\Lizy\Debug;

require '../src/bootStrap.php';

try {
    header('Cache-Control: private, max-age=0, no-cache, no-store');
    header('Pragma: no-cache');
    header('Content-Type: text/plain; charset=utf-8');
    echo "hayé";
} catch (Throwable $e) {
    print_r($e);
    Debug::get($e)->log();
}
