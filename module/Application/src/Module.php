<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();

        $sharedEventManager->attach(AbstractActionController::class,
            MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
    }

    public function controlUserSession($sessionManager, $event)
    {
        $sessionContainer = new Container('AuthContainer', $sessionManager);
        $maxInactivePeriod = 60 * 60 * 1;

        if (isset($sessionContainer->authorized)) {
            $currentTime = time();
            if (!isset($sessionContainer->endTime)) {
                $sessionContainer->endTime = $currentTime + $maxInactivePeriod;
            }
            if ($currentTime > $sessionContainer->endTime) {
                $sessionManager->expireSessionCookie();
                $controller = $event->getTarget();
                return $controller->redirect()->toRoute('login');
            } else {
                $sessionContainer->endTime = $currentTime + $maxInactivePeriod;
            }
        }
    }

    public function onDispatch(MvcEvent $event)
    {
        $sessionManager = $event->getApplication()->getServiceManager()->get('Zend\Session\SessionManager');
        $this->controlUserSession($sessionManager, $event);
    }
}
