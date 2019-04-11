<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 11.04.2019
 * Time: 16:09
 */

namespace Application\Repository;

use Application\Entity\SavedPost;
use Doctrine\ORM\EntityRepository;

class SavedPostRepository extends EntityRepository
{
    public function isSavedPost($postId, $userId)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('s')->from(SavedPost::class, 's');
        $queryBuilder->where('s.user = ' . $userId);
        $queryBuilder->andWhere('s.post = ' . $postId);
        $savedPosts = $queryBuilder->getQuery()->getResult();

        if (count($savedPosts) > 0){
            return true;
        }
        return false;
    }

    public function getSavedPost($postId, $userId)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('s')->from(SavedPost::class, 's');
        $queryBuilder->where('s.user = ' . $userId);
        $queryBuilder->andWhere('s.post = ' . $postId);
        $savedPost = $queryBuilder->getQuery()->getResult();

        return $savedPost[0];
    }
}