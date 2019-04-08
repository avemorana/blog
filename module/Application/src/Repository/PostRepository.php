<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:50
 */

namespace Application\Repository;

use Application\Entity\Post;
use Application\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getAllPost($options)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('p')->from(Post::class, 'p');
        if ($options['tag'] != -1) {
            $queryBuilder->join('p.tags', 't');
            $queryBuilder->where('t.id = ' . $options['tag']);
        }
        $queryBuilder->orderBy('p.date', 'DESC');

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