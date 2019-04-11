<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 11.04.2019
 * Time: 14:58
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Application\Repository\SavedPostRepository")
 * @ORM\Table(name="saved_post")
 */
class SavedPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
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
     * @ORM\Column(name="date_saved")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Post", inversedBy="post")
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
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
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
        $post->addSavePost($this);
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
        $user->addSavedPost($this);
    }
}