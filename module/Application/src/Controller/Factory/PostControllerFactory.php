<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:48
 */

namespace Application\Controller\Factory;

use Application\Controller\PostController;
use Application\Service\PostManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $postManager = $container->get(PostManager::class);

        return new PostController($entityManager, $postManager);
    }
}