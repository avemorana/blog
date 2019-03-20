<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 03.10.2018
 * Time: 11:45
 */

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Service\UserManager;
use User\Controller\UserController;

/**
 * Это фабрика для UserController. Ее целью является инстанцирование
 * контроллера.
 */
class UserControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userManager = $container->get(UserManager::class);

        // Инстанцируем контроллер и внедряем зависимости
        return new UserController($entityManager, $userManager);
    }
}