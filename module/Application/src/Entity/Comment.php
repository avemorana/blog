<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 02.04.2019
 * Time: 14:13
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Application\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 */
class Comment
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="comment_id")
     * */
    protected $id;

    /**
     * @ORM\Column(name="post_id")
     */
    protected $postId;

    /**
     * @ORM\Column(name="user_id")
     */
    protected $userId;

    /**
     * @ORM\Column(name="date_created")
     */
    protected $date;

    /**
     * @ORM\Column(name="content")
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Post", inversedBy="post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="post_id")
     */
    protected $post;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User", inversedBy="user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param mixed $postId
     */
    public function setPostId($postId): void
    {
        $this->postId = $postId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return \User\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \User\Entity\User $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
        $user->addComment($this);
    }

    /**
     * @return \Application\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param \Application\Entity\Post $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
        $post->addComment($this);
    }

}