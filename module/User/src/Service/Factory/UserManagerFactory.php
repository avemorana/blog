<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 03.10.2018
 * Time: 11:34
 */

namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Service\UserManager;

/**
 * Это фабрика для UserManager. Ее целью является
 * инстанцирование сервиса.
 */
class UserManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Инстанцируем сервис и внедряем зависимости.
        return new UserManager($entityManager);
    }
}