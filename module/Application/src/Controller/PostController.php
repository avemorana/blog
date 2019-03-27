<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:48
 */

namespace Application\Controller;

use Application\Entity\Post;
use Application\Form\PostForm;
use User\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class PostController extends AbstractActionController
{
    /**
     * Менеджер сущностей.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Менеджер постов.
     * @var Application\Service\PostManager
     */
    private $postManager;


    public function __construct($entityManager, $postManager)
    {
        $this->entityManager = $entityManager;
        $this->postManager = $postManager;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $route = $this->params()->fromRoute('route');

        $query = $this->entityManager->getRepository(Post::class)
            ->getAllPost();
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel([
            'posts' => $paginator,
            'route' => $route
        ]);
    }

    public function oneAction()
    {
        $postId = $this->params()->fromRoute('id', -1);

        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'post' => $post
        ]);
    }

    public function addAction()
    {
        $form = new PostForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                if ($this->identity() != null) {
                    $user = $this->entityManager->getRepository(User::class)
                        ->findOneByLogin($this->identity());
                    $data['user'] = $user;
                }
                $this->postManager->addPost($data);
                return $this->redirect()->toRoute('post');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);


    }

    public function editAction()
    {
        $postId = $this->params()->fromRoute('id', -1);

        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        if (!$post->isAuthor($this->identity()) || !$post->canBeEdit()) {
            return new ViewModel([
                'error' => 'The post cannot be edited'
            ]);
        }

        $form = new PostForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                $this->postManager->updatePost($post, $data);
                return $this->redirect()->toRoute('post', ['action' => 'one', 'id' => $postId]);
            }

        } else {
            $data = [
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
            ];
            $form->setData($data);
        }

        return new ViewModel([
            'form' => $form
        ]);

    }

    public function deleteAction()
    {
        $postId = $this->params()->fromRoute('id', -1);

        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        if (!$post->isAuthor($this->identity())) {
            return new ViewModel([
                'error' => 'The post cannot be deleted'
            ]);
        }

        $this->postManager->deletePost($post);
        $this->redirect()->toRoute('home');
    }
}