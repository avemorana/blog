<?php

namespace User\Service;

use Zend\Authentication\Result;

/**
 * The AuthManager service is responsible for user's login/logout and simple access
 * filtering. The access filtering feature checks whether the current visitor
 * is allowed to see the given page or not.
 */
class AuthManager
{
    /**
     * Authentication service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * Session manager.
     * @var Zend\Session\SessionManager
     */
    private $sessionManager;

    /**
     * Contents of the 'access_filter' config key.
     * @var array
     */
    private $config;


    public function __construct($authService, $sessionManager, $config)
    {
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
        $this->config = $config;
    }


    public function login($login, $password)
    {

        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setLogin($login);
        $authAdapter->setPassword($password);
        $result = $this->authService->authenticate();

        return $result;
    }

    public function isLogged()
    {
        return $this->authService->getIdentity() != null;
    }

    /**
     * Performs user logout.
     */
    public function logout()
    {
        if ($this->authService->getIdentity() == null) {
            return 'The user is not logged in';
        }

        $this->authService->clearIdentity();
    }


    public function filterAccess($controllerName, $actionName)
    {
        $mode = isset($this->config['options']['mode']) ? $this->config['options']['mode'] : 'restrictive';
        if ($mode != 'restrictive' && $mode != 'permissive')
            throw new \Exception('Invalid access filter mode (expected either restrictive or permissive mode');

        if (isset($this->config['controllers'][$controllerName])) {
            $items = $this->config['controllers'][$controllerName];
            foreach ($items as $item) {
                $actionList = $item['actions'];
                $allow = $item['allow'];
                if (is_array($actionList) && in_array($actionName, $actionList) ||
                    $actionList == '*') {
                    if ($allow == '*')
                        return true; // Anyone is allowed to see the page.
                    else if ($allow == '@' && $this->authService->hasIdentity()) {
                        return true; // Only authenticated user is allowed to see the page.
                    } else {
                        return false; // Access denied.
                    }
                }
            }
        }

        // In restrictive mode, we forbid access for unauthorized users to any 
        // action not listed under 'access_filter' key (for security reasons).
        if ($mode == 'restrictive' && !$this->authService->hasIdentity())
            return false;

        // Permit access to this page.
        return true;
    }
}