<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 02.04.2019
 * Time: 14:23
 */

namespace Application\Repository;

use Application\Entity\Comment;
use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function getCommentsByPostId($postId)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('c')
            ->from(Comment::class, 'c')
            ->where('c.postId = ' . $postId)
            ->orderBy('c.date', 'DESC');

        $posts = $queryBuilder->getQuery();
        return $posts;
    }

    public function getCommentsByUserId($userId)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('c')
            ->from(Comment::class, 'c')
            ->where('c.userId = ' . $userId)
            ->orderBy('c.date', 'DESC');

        $posts = $queryBuilder->getQuery();
        return $posts;
    }
}