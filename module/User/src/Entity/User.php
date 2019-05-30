<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 27.09.2018
 * Time: 16:18
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\User\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="user_id")
     * */
    protected $id;

    /**
     * @ORM\Column(name="login")
     */
    protected $login;

    /**
     * @ORM\Column(name="password")
     */
    protected $password;

    /**
     * @ORM\Column(name="email")
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Post", mappedBy="user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $posts;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Comment", mappedBy="user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\SavedPost", mappedBy="user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $savedPosts;

    /**
     * @ORM\ManyToMany(targetEntity="\User\Entity\User", inversedBy="blockedMe")
     * @ORM\JoinTable(name="blocked_user",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="blocked_id", referencedColumnName="user_id")}
     *      )
     */
    protected $blockedByMe;

    /**
     * @ORM\ManyToMany(targetEntity="\User\Entity\User", mappedBy="blockedByMe")
     */
    protected $blockedMe;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return array
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param $post
     */
    public function addPost($post)
    {
        $this->posts[] = $post;
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
     * @return array
     */
    public function getSavedPosts()
    {
        return $this->savedPosts;
    }

    /**
     * @param $savedPost
     */
    public function addSavedPost($savedPost)
    {
        $this->savedPosts[] = $savedPost;
    }

    /**
     * @return mixed
     */
    public function getBlockedByMe()
    {
        return $this->blockedByMe;
    }

    public function addBlockedByMe($blockedUser)
    {
        $this->blockedByMe[] = $blockedUser;
    }

    public function removeBlockedAssociation($blockedUser)
    {
        $this->blockedByMe->removeElement($blockedUser);
    }

    public function isBlocked($blockedUser)
    {
        return in_array($blockedUser, $this->blockedByMe->toArray());
    }

    /**
     * @return mixed
     */
    public function getBlockedMe()
    {
        return $this->blockedMe;
    }

    public function addUserBlockedMe($blockedMeUser)
    {
        $this->blockedMe[] = $blockedMeUser;
    }

}