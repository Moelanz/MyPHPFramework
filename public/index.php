<?php
declare(strict_types=1);
use App\Kernel;

require __DIR__.'/../vendor/autoload.php';
include __DIR__.'/../config/database.php';

$kernel = new Kernel();
$kernel->handleRequest();

//dump($kernel->getContainer()->getServices());
