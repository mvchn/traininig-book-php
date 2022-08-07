<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\BookListCommand;

$app = new Application();

$app->add(new BookListCommand());

$app->run();
