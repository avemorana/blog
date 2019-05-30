<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 22.01.2019
 * Time: 14:21
 */

namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\User;

class UserRepository extends EntityRepository
{
    public function findAllUsers()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->orderBy('u.login', 'ASC');

        $users = $queryBuilder->getQuery();
        return $users;
    }

    public function getBlockedUsers($userId)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('u', 'b')->from(User::class, 'u');
        $queryBuilder->join('u.blockedMe', 'b');
        $queryBuilder->where('b.id = ' . $userId);
        $blockedUsers = $queryBuilder->getQuery();

        return $blockedUsers;
    }

    public function getBlockedIds($userId)
    {
        $entityManager = $this->getEntityManager();

        $currentUser = $entityManager->getRepository(User::class)
            ->findOneById($userId);

        $ids = array();
        foreach ($currentUser->getBlockedByMe() as $blockedUser){
            $ids[] = $blockedUser->getId();
        }

        return $ids;
    }
}