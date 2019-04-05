<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:50
 */

namespace Application\Service;

use Application\Entity\Comment;
use Application\Entity\Post;
use Application\Entity\Tag;
use Zend\Filter\StaticFilter;

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
        $this->addTagsToPost($data['tags'], $post);
        $this->entityManager->flush();
    }

    public function addTagsToPost($tagString, $post)
    {
        $tags = $post->getTags();
        foreach ($tags as $tag){
            $post->removeTagAssociation($tag);
        }

        $tags = explode(',', $tagString);
        foreach ($tags as $tagName){
            $tagName = strtolower(trim($tagName));
            if (empty($tagName)){
                continue;
            }

            $tag = $this->entityManager->getRepository(Tag::class)
                ->findOneByName($tagName);
            if ($tag == null){
                $tag = new Tag();
            }
            $tag->setName($tagName);
            $tag->addPost($post);

            $this->entityManager->persist($tag);
            $post->addTag($tag);
        }
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

    public function addComment($data)
    {
        $comment = new Comment();

        $comment->setUser($data['user']);
        $comment->setPost($data['post']);
        $comment->setContent($data['content']);
        $comment->setDate(date('Y-m-d H:i:s'));

        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}