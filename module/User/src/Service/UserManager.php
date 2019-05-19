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
        if ($this->checkUserExists($data['login'])) {
            return "Login '" . $data['login'] . "' already in use";
        }

        $user = new User();
        $user->setLogin($data['login']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

        // создание новой записи в таблице
        $this->entityManager->persist($user);
        // записать изменения в бд
        $this->entityManager->flush();
    }

    public function updateUser($user, $data)
    {
        if ($this->checkUserExists($data['login'])) {
            return "Login '" . $data['login'] . "' already in use";
        }

        $user->setLogin($data['login']);
        $user->setPassword($data['password']);

        $this->entityManager->flush();
    }

    public function removeUser($user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function checkUserExists($login)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneByLogin($login);

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