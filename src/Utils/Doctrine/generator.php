<?php

/**
 * https://gist.github.com/tawfekov/4079388
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

define('ABSPATH', realpath(__DIR__ . '/../../../'));

$classLoader = new \Doctrine\Common\ClassLoader('App\Entity', ABSPATH . '/src/Entity');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
$classLoader->register();
// config
$config = new \Doctrine\ORM\Configuration();
$config->setMetadataDriverImpl($config->newDefaultAnnotationDriver([ABSPATH . '/src/Entity']));
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');
$connectionParams = array(
    'driver' => 'mysqli',
    'host' => '192.168.0.101',
    'port' => '3306',
    'user' => 'root',
    'password' => '123123q',
    'dbname' => 'bee_jee',
    'charset' => 'utf8',
);
$em = \Doctrine\ORM\EntityManager::create($connectionParams, $config);
// custom datatypes (not mapped for reverse engineering)
$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('bit', 'boolean');
// fetch metadata
$driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
    $em->getConnection()->getSchemaManager()
);
$em->getConfiguration()->setMetadataDriverImpl($driver);
$cmf = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory();
$cmf->setEntityManager($em);
// edit to filter \Doctrine\ORM\Mapping\Driver\DatabaseDriver::reverseEngineerMappingFromDatabase:270
$classes = $driver->getAllClassNames();
$metadata = $cmf->getAllMetadata();
$generator = new Doctrine\ORM\Tools\EntityGenerator();
$generator->setUpdateEntityIfExists(true);
$generator->setGenerateStubMethods(true);
$generator->setGenerateAnnotations(true);
$generator->generate($metadata, ABSPATH . '/src/Entity');
print "Done!\n";