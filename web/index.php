<?php declare(strict_types = 1);

use Takoma\Lizy\Debug;
use Takoma\PoleEmploi\CatalogueFormations\Api\Provider\RestApiProvider;

require '../src/bootStrap.php';

try {
    RestApiProvider::init();

} catch (\Exception $e) {
    Debug::get($e)->log();
} catch (\Throwable $e) {
    Debug::get($e)->log();
}
