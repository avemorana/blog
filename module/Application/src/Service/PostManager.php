<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:50
 */

namespace Application\Service;

use Application\Entity\Post;

class PostManager
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

    public function addPost($data)
    {
        $post = new Post();

        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $post->setDate(date('Y-m-d H:i:s'));
        $post->setUser($data['user']);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function updatePost($post, $data)
    {
        $post->setTitle($data['title']);
        $post->setContent($data['content']);

        $this->entityManager->flush();
    }

    public function deletePost($post)
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}