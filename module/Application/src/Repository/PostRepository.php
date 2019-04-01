<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:50
 */

namespace Application\Repository;

use Application\Entity\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getAllPost()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->orderBy('p.date', 'DESC');

        $posts = $queryBuilder->getQuery();
        return $posts;
    }

    public function getPostsByUser($userId)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->where('p.user = ' . $userId)
            ->orderBy('p.date', 'DESC');

        $posts = $queryBuilder->getQuery();
        return $posts;
    }
}