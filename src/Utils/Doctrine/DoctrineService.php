<?php

namespace App\Utils\Doctrine;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\EntityManager;
use Exception;

class DoctrineService
{
    /**
     * @var array
     */
    protected $paths;

    /**
     * @var bool
     */
    protected $isDevMode;

    /**
     * @var EntityManager[]
     */
    protected $entityManagers = [];

    /**
     * DoctrineService constructor.
     * @param array $paths
     * @param bool $isDevMode
     */
    public function __construct(array $paths, $isDevMode = false)
    {
        $this->paths = $paths;
        $this->isDevMode = $isDevMode;
    }

    /**
     * @param string $name
     * @return EntityManager
     * @throws Exception
     * @throws ORMException
     * @throws DBALException
     */
    public function getEntityManager($name = 'default')
    {
        if (!$this->entityManagers) {
            $configurationFile = ABSPATH . '/config/database.php';
            $configuration = file_exists($configurationFile) ? (include $configurationFile) : ['connections' => []];

            foreach ($configuration['connections'] as $connectionName => $connectionSettings) {
                // the connection configuration
                $dbParams = array(
                    'driver'   => $connectionSettings['driver'],
                    'host'   => $connectionSettings['host'],
                    'dbname'   => $connectionSettings['dbname'],
                    'user'     => $connectionSettings['user'],
                    'password' => $connectionSettings['password'],
                    'charset' => $connectionSettings['charset']
                );

                $cache = new ArrayCache;
                $config = new Configuration;
                $config->setMetadataCacheImpl($cache);
                $driverImpl = $config->newDefaultAnnotationDriver($this->paths, false);
                $config->setMetadataDriverImpl($driverImpl);
                $config->setQueryCacheImpl($cache);
                $config->setProxyDir(ABSPATH . '/src/Utils/Doctrine/Proxies');
                $config->setProxyNamespace('App\Utils\Doctrine\Proxies');
                $config->setAutoGenerateProxyClasses(true);

                $entityManager = EntityManager::create($dbParams, $config);

                $entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('bit', Type::BOOLEAN);
                $entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', Type::STRING);

                $this->entityManagers[$connectionName] = $entityManager;
            }
        }

        if (!isset($this->entityManagers[$name])) {
            throw new Exception("Wrong entity manager name {$name}");
        }

        return $this->entityManagers[$name];
    }
}
