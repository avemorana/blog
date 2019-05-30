<?php

namespace User\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use User\Entity\User;

/**
 * Adapter used for authenticating user. It takes login and password on input
 * and checks the database if there is a user with such login (email) and password.
 * If such user exists, the service returns its identity (email). The identity
 * is saved to session and can be retrieved later with Identity view helper provided
 * by ZF3.
 */
class AuthAdapter implements AdapterInterface
{
    /**
     * User login.
     * @var string
     */
    private $login;

    /**
     * Password
     * @var string
     */
    private $password;

    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Sets user email.
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Sets password.
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }

    /**
     * Performs an authentication attempt.
     */
    public function authenticate()
    {
        if (stripos($this->login, '@') === false) {
            $user = $this->entityManager->getRepository(User::class)
                ->findOneByLogin($this->login);
        } else {
            $user = $this->entityManager->getRepository(User::class)
                ->findOneByEmail($this->login);
        }

        if ($user == null) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']);
        }

//        if ($user->getActive() == User::INACTIVE) {
//            return new Result(
//                Result::FAILURE,
//                null,
//                ['User is inactive.']);
//        }

        if (password_verify($this->password, $user->getPassword())) {
            return new Result(
                Result::SUCCESS,
                $user->getId(), // identity
                ['Authenticated successfully.']);
        }

        return new Result(
            Result::FAILURE_CREDENTIAL_INVALID,
            null,
            ['Invalid credentials.']);
    }
}


