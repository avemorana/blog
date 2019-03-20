<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

//use User\Controller\AuthController;
//use User\Service\AuthManager;
//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\Mvc\MvcEvent;
//use Zend\Session\SessionManager;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

//    public function onBootstrap(MvcEvent $event)
//    {
//        $admin = $event->getApplication();
//        $serviceManager = $admin->getServiceManager();
//
//        $sessionManager = $serviceManager->get(SessionManager::class);
//    }

//    public function onBootstrap(MvcEvent $event)
//    {
//        // Get event manager.
//        $eventManager = $event->getApplication()->getEventManager();
//        $sharedEventManager = $eventManager->getSharedManager();
//        // Register the event listener method.
//        $sharedEventManager->attach(AbstractActionController::class,
//            MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
//    }
//
//    public function onDispatch(MvcEvent $event)
//    {
//        // Получаем контроллер и действие, которому был отправлен HTTP-запрос.
//        $controller = $event->getTarget();
//        $controllerName = $event->getRouteMatch()->getParam('controller', null);
//        $actionName = $event->getRouteMatch()->getParam('action', null);
//
//        // Конвертируем имя действия с пунктирами в имя в верблюжьем регистре.
//        $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));
//
//        // Получаем экземпляр сервиса AuthManager.
//        $authManager = $event->getApplication()->getServiceManager()->get(AuthManager::class);
//
//        // Выполняем фильтр доступа для каждого контроллера кроме AuthController
//        // (чтобы избежать бесконечного перенаправления).
//        if ($controllerName!=AuthController::class &&
//            !$authManager->filterAccess($controllerName, $actionName)) {
//
//            // Перенаправляем пользователя на страницу "Login".
//            return $controller->redirect()->toRoute('login');
//        }
//    }

}
