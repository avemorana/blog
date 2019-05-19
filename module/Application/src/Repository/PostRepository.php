<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:50
 */

namespace Application\Repository;

use Application\Entity\Post;
use Application\Entity\SavedPost;
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

    public function getAmountPostsByUser($userId)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('COUNT(p.id)')
            ->from(Post::class, 'p')
            ->where('p.user = ' . $userId);
//            ->orderBy('p.date', 'DESC');

        $posts = $queryBuilder->getQuery()->getResult();
        return $posts[0][1];
    }

    public function getPostsHavingAnyTag()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')->from(Post::class, 'p');
        $queryBuilder->join('p.tags', 't');
        $queryBuilder->orderBy('p.date', 'DESC');
        $posts = $queryBuilder->getQuery()->getResult();
        return $posts;
    }

    public function getPostsByTag($tagId)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('p')->from(Post::class, 'p');
        $queryBuilder->join('p.tags', 't');
        $queryBuilder->where('t.id = ' . $tagId);
        $queryBuilder->orderBy('p.date', 'DESC');

        $posts = $queryBuilder->getQuery()->getResult();
        return $posts;
    }

    public function getSavedPostByUser($userId)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('p')->from(Post::class, 'p');
        $queryBuilder->join(
            SavedPost::class,
            's',
            \Doctrine\ORM\Query\Expr\Join::WITH,
            's.post = p.id');
        $queryBuilder->where('s.user =' . $userId);
        $queryBuilder->orderBy('s.date', 'DESC');

        $posts = $queryBuilder->getQuery();
        return $posts;
    }
}