<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 01.04.2019
 * Time: 10:40
 */

namespace User\Controller;

use Application\Entity\Comment;
use Application\Entity\Post;
use User\Entity\User;
use User\Form\ChangePasswordForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class ProfileController extends AbstractActionController
{
    /**
     * Менеджер сущностей.
     * @var Doctrine\ORM\EntityManager
     */
    public $entityManager;

    /**
     * Менеджер постов.
     * @var User\Service\UserManager
     */
    private $userManager;

    private $user;

    public function __construct($entityManager, $userManager)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
    }

    public function dispatch(Request $request, Response $response = null)
    {
        $this->user = $this->entityManager->getRepository(User::class)
            ->findOneByLogin($this->identity());
        return parent::dispatch($request, $response); // TODO: Change the autogenerated stub
    }

    public function indexAction()
    {
        return new ViewModel([
            'user' => $this->user
        ]);
    }

    public function postsAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $query = $this->entityManager->getRepository(Post::class)
            ->getPostsByUser($this->user->getId());
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel([
            'posts' => $paginator,
        ]);
    }

    public function changepasswordAction()
    {
        $form = new ChangePasswordForm();

        if ($this->getRequest()->isPost()){
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()){
                $data = $form->getData();
                $error = false;
                if (!password_verify($data['old-password'], $this->user->getPassword())){
                    $form->get('old-password')->setMessages(['Old password is incorrect']);
                    $error = true;
                }
                if ($data['password'] != $data['re-password']){
                    $form->get('re-password')->setMessages(['Passwords do not match']);
                    $error = true;
                }

                if (!$error){
                    $data['user'] = $this->user;
                    $this->userManager->updatePassword($data);
                    $message = "Password was successfully changed";
                }
            }

        }

        return new ViewModel([
            'form' => $form,
            'message' => $message
        ]);
    }

    public function commentsAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $query = $this->entityManager->getRepository(Comment::class)
            ->getCommentsByUserId($this->user->getId());
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(9);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel([
            'comments' => $paginator
        ]);
    }

    public function savedAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $query = $this->entityManager->getRepository(Post::class)
            ->getSavedPostByUser($this->user->getId());
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel([
            'posts' => $paginator,
        ]);
    }

    public function blockedAction()
    {
        // TODO: paginator
        $page = $this->params()->fromQuery('page', 1);

        $query = $this->entityManager->getRepository(User::class)
            ->getBlockedUsers($this->user->getId());
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel([
            'users' => $paginator,
            'entityManager' => $this->entityManager
        ]);
    }

}