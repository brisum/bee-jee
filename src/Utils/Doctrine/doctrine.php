<?php
/** copy of vendor/bin/doctine.php  **/

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Utils\Doctrine\DoctrineService;
use Brisum\Lib\ObjectManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../../../bootstrap.php';

/** @var DoctrineService $doctrineService */
$doctrineService = ObjectManager::getInstance()->get('App\Utils\Doctrine\DoctrineService');
$entityManager = $doctrineService->getEntityManager();
$helperSet = ConsoleRunner::createHelperSet($entityManager);
$commands = array();

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet, $commands);
