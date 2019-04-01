<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 01.04.2019
 * Time: 10:44
 */

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use User\Service\UserManager;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Controller\ProfileController;

class ProfileControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userManager = $container->get(UserManager::class);

        return new ProfileController($entityManager, $userManager);
    }
}