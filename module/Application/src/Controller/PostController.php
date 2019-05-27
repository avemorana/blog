<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:48
 */

namespace Application\Controller;

use Application\Entity\Comment;
use Application\Entity\Post;
use Application\Entity\SavedPost;
use Application\Form\CommentForm;
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
        $tag = $this->params()->fromQuery('tag', -1);

        $query = $this->entityManager->getRepository(Post::class)
            ->getAllPost(array('tag' => $tag));
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);

        $tagCloud = $this->postManager->getTagCloud();

        return new ViewModel([
            'posts' => $paginator,
            'params' => ['tag' => $tag],
            'tagCloud' => $tagCloud
        ]);
    }

    public function authorAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $tag = $this->params()->fromQuery('tag', -1);
        $authorId = $this->params()->fromRoute('id', -1);

        $author =  $this->entityManager->getRepository(User::class)
            ->findOneById($authorId);

        if ($author == null){
            $this->redirect()->toRoute('post', ['action' => 'index']);
        }

        $query = $this->entityManager->getRepository(Post::class)
            ->getAllPost(array('tag' => $tag, 'author' => $authorId));
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);

        $tagCloud = $this->postManager->getTagCloud();

        return new ViewModel([
            'posts' => $paginator,
            'params' => ['tag' => $tag],
            'tagCloud' => $tagCloud,
            'author' => $author
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

        $page = $this->params()->fromQuery('page', 1);

        $query = $this->entityManager->getRepository(Comment::class)
            ->getCommentsByPostId($postId);
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);

        $form = new CommentForm();

        $user = $this->entityManager->getRepository(User::class)
            ->findOneByLogin($this->identity());

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                if ($this->identity() != null) {
                    $data['user'] = $user;
                }
                $data['post'] = $post;
            }
            $this->postManager->addComment($data);
            return $this->redirect()->refresh();
        }

        $isSaved = $this->entityManager->getRepository(SavedPost::class)
            ->isSavedPost($post->getId(), $user->getId());

        return new ViewModel([
            'post' => $post,
            'form' => $form,
            'comments' => $paginator,
            'isSaved' => $isSaved,
            'isAuthor' => $post->isAuthor($this->identity()),
            'isBlocked' => $user->isBlocked($post->getUser())
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
                'tags' => $this->postManager->convertTagsToString($post)
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

    public function addtosavedAction()
    {
        $postId = $this->params()->fromRoute('id', -1);
        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $user = $this->entityManager->getRepository(User::class)
            ->findOneByLogin($this->identity());

        $this->postManager->addPostToSaved($user, $post);
        $this->redirect()->toRoute('post', ['action' => 'one', 'id' => $postId]);
    }

    public function deletesavedAction()
    {
        $postId = $this->params()->fromRoute('id', -1);
        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $user = $this->entityManager->getRepository(User::class)
            ->findOneByLogin($this->identity());

        $this->postManager->deletePostFromSaved($user, $post);
        $this->redirect()->toRoute('post', ['action' => 'one', 'id' => $postId]);
    }
}