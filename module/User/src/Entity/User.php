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
     * @ORM\OneToMany(targetEntity="\Application\Entity\Post", mappedBy="user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    protected $posts;


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
}