<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\BookListCommand;
use App\Command\BookRunCommand;
use App\Repository\BookRepository;

$app = new Application();

$books = new BookRepository();
$app->add(new BookListCommand('app:book-list', $books));
$app->add(new BookRunCommand('app:book-run', $books));

$app->run();
