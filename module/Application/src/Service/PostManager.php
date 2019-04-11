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
use Application\Entity\SavedPost;
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
        foreach ($tags as $tag) {
            $post->removeTagAssociation($tag);
        }

        $tags = explode(',', $tagString);
        $tags = array_unique($tags);
        foreach ($tags as $tagName) {
            $tagName = strtolower(trim($tagName));
            if (empty($tagName)) {
                continue;
            }

            $tag = $this->entityManager->getRepository(Tag::class)
                ->findOneByName($tagName);
            if ($tag == null) {
                $tag = new Tag();
            }
            $tag->setName($tagName);
            $tag->addPost($post);

            $this->entityManager->persist($tag);
            $post->addTag($tag);
        }
    }

    public function convertTagsToString($post)
    {
        $tags = $post->getTags();
        $tagCount = count($tags);
        $tagString = '';
        $i = 0;
        foreach ($tags as $tag) {
            $i++;
            $tagString .= $tag->getName();
            if ($i < $tagCount) {
                $tagString .= ', ';
            }
        }

        return $tagString;
    }

    public function updatePost($post, $data)
    {
        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $this->addTagsToPost($data['tags'], $post);

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

    public function getTagCloud()
    {
        $tagCloud = [];
        $posts = $this->entityManager->getRepository(Post::class)
            ->getPostsHavingAnyTag();
        $totalPostCount = count($posts);
        $tags = $this->entityManager->getRepository(Tag::class)->findAll();

        foreach ($tags as $tag) {
            $postsByTag = $this->entityManager->getRepository(Post::class)
                ->getPostsByTag($tag->getId());
            $postCount = count($postsByTag);
            if ($postCount > 0) {
                $tagCloud[$tag->getId()] = ['name' => $tag->getName(),
                    'count' => $postCount / $totalPostCount];
            }
        }

        return $tagCloud;
    }

    public function addPostToSaved($user, $post)
    {
        $isSaved = $this->entityManager->getRepository(SavedPost::class)
            ->isSavedPost($post->getId(), $user->getId());
        if (!$isSaved) {
            $savedPost = new SavedPost();
            $savedPost->setDate(date('Y-m-d H:i:s'));
            $savedPost->setUser($user);
            $savedPost->setPost($post);

            $this->entityManager->persist($savedPost);
            $this->entityManager->flush();
        }
    }

    public function deletePostFromSaved($user, $post)
    {
        $savedPost = $this->entityManager->getRepository(SavedPost::class)
            ->getSavedPost($post->getId(), $user->getId());
        $this->entityManager->remove($savedPost);
        $this->entityManager->flush();
    }
}