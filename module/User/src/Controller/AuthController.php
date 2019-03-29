<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use User\Form\LoginForm;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class AuthController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Auth manager.
     * @var User\Service\AuthManager
     */
    private $authManager;

    /**
     * User manager.
     * @var User\Service\UserManager
     */
    private $userManager;

    /**
     * Session container.
     * @var Zend\Session\Container
     */
    private $sessionContainer;


    public function __construct($entityManager, $authManager,
                                $userManager, $sessionContainer)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->userManager = $userManager;
        $this->sessionContainer = $sessionContainer;
    }

    /**
     * Authenticates user given email address and password credentials.
     */
    public function loginAction()
    {
        $form = new LoginForm();
        $isLoginError = false;

        if ($this->authManager->isLogged()){
            return new ViewModel([
                'form' => $form,
                'message' => 'You are already logged in'
            ]);
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $result = $this->authManager->login($data['login'], $data['password']);
                if ($result->getCode() != Result::SUCCESS) {
                    $isLoginError = true;
                    $form->get('login')->setMessages($result->getMessages());
                } else {
                    $this->sessionContainer->authorized = true;
                    return $this->redirect()->toRoute('home');
                }
            } else {
                $isLoginError = true;
            }
        }

        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError,
        ]);
    }

    public function logoutAction()
    {
        $this->authManager->logout();
        return $this->redirect()->toRoute('login');
    }
}
