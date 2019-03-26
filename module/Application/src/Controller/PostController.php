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
        $posts = $this->entityManager->getRepository(Post::class)->findAll();

        return new ViewModel([
            'posts' => $posts
        ]);
    }

    public function addAction()
    {
        $form = new PostForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()){
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
}