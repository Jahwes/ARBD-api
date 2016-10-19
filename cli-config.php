<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$app = require __DIR__ . "/public/index.php";

$entity_manager = $app["orm.em"];

return ConsoleRunner::createHelperSet($entity_manager);
