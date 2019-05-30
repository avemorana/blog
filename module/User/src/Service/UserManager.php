<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 03.10.2018
 * Time: 11:26
 */

namespace User\Service;


use User\Entity\User;

class UserManager
{
    /**
     * Doctrine entity manager
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addNewUser($data)
    {
        if ($this->checkLoginIsUsed($data['login'])) {
            $messages['login'] = "Login '" . $data['login'] . "' already in use";
        }
        if ($this->checkEmailIsUsed($data['email'])) {
            $messages['email'] = "E-mail '" . $data['email'] . "' already in use";
        }
        if ($messages){
            return $messages;
        }

        $user = new User();
        $user->setLogin($data['login']);
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

        // создание новой записи в таблице
        $this->entityManager->persist($user);
        // записать изменения в бд
        $this->entityManager->flush();
    }

    public function updateUser($user, $data)
    {
        if ($this->checkLoginIsUsed($data['login'])) {
            $messages['login'] = "Login '" . $data['login'] . "' already in use";
        }
        if ($this->checkEmailIsUsed($data['email'])) {
            $messages['email'] = "E-mail '" . $data['email'] . "' already in use";
        }
        if ($messages){
            return $messages;
        }

        $user->setLogin($data['login']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        $this->entityManager->flush();
    }

    public function removeUser($user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function checkLoginIsUsed($login)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneByLogin($login);

        return $user !== null;
    }

    public function checkEmailIsUsed($email)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneByEmail($email);

        return $user !== null;
    }

    public function updatePassword($data)
    {
        $data['user']->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        $this->entityManager->flush();
    }

    public function addUserToBlocked($user, $blockedUser)
    {
        $user->addBlockedByMe($blockedUser);
        $this->entityManager->flush();
    }

    public function deleteUserFromBlocked($user, $blockedUser)
    {
        $user->removeBlockedAssociation($blockedUser);
        $this->entityManager->flush();
    }
}