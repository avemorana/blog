<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:50
 */

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Application\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{
    const SHORT_CONTENT_LENGTH = 200;
    const EDIT_POST_PERIOD = 24 * 3600;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="post_id")
     * */
    protected $id;

    /**
     * @ORM\Column(name="title")
     */
    protected $title;

    /**
     * @ORM\Column(name="content")
     */
    protected $content;

    /**
     * @ORM\Column(name="user_id")
     */
    protected $userId;

    /**
     * @ORM\Column(name="date_created")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User", inversedBy="user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Comment", mappedBy="post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="post_id")
     */
    protected $comments;

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Entity\Tag", inversedBy="post")
     * @ORM\JoinTable(name="post_tag",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="post_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="tag_id")}
     *      )
     */
    protected $tags;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
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
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $user
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
     * @param \User\Entity\User $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
        $user->addPost($this);
    }

    /**
     * @return \User\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getShortContent()
    {
        if (strlen($this->content) < self::SHORT_CONTENT_LENGTH) {
            return $this->content;
        } else {
            $short = mb_substr($this->content, 0, self::SHORT_CONTENT_LENGTH);
            $short .= '...';
            return $short;
        }
    }

    public function isAuthor($login)
    {
        if ($this->user->getLogin() === $login) {
            return true;
        }
        return false;
    }

    public function canBeEdit()
    {
        $now = time();
        $lastDate = strtotime($this->date) + self::EDIT_POST_PERIOD;

        if ($now < $lastDate) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param $comment
     */
    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }

    public function removeTagAssociation($tag)
    {
        $this->tags->removeElement($tag);
    }
}