<?php

namespace DoctrineORMModule\Proxy\__CG__\Application\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Post extends \Application\Entity\Post implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'title', 'content', 'userId', 'date', 'user', 'comments', 'tags', 'savedPosts'];
        }

        return ['__isInitialized__', 'id', 'title', 'content', 'userId', 'date', 'user', 'comments', 'tags', 'savedPosts'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Post $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitle', []);

        return parent::getTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitle($title): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitle', [$title]);

        parent::setTitle($title);
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContent', []);

        return parent::getContent();
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContent', [$content]);

        parent::setContent($content);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserId', []);

        return parent::getUserId();
    }

    /**
     * {@inheritDoc}
     */
    public function setUserId($userId): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUserId', [$userId]);

        parent::setUserId($userId);
    }

    /**
     * {@inheritDoc}
     */
    public function getDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDate', []);

        return parent::getDate();
    }

    /**
     * {@inheritDoc}
     */
    public function setDate($date): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDate', [$date]);

        parent::setDate($date);
    }

    /**
     * {@inheritDoc}
     */
    public function setUser($user): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', [$user]);

        parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', []);

        return parent::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function getShortContent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShortContent', []);

        return parent::getShortContent();
    }

    /**
     * {@inheritDoc}
     */
    public function isAuthor($login)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isAuthor', [$login]);

        return parent::isAuthor($login);
    }

    /**
     * {@inheritDoc}
     */
    public function canBeEdit()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'canBeEdit', []);

        return parent::canBeEdit();
    }

    /**
     * {@inheritDoc}
     */
    public function getComments()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComments', []);

        return parent::getComments();
    }

    /**
     * {@inheritDoc}
     */
    public function addComment($comment)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addComment', [$comment]);

        return parent::addComment($comment);
    }

    /**
     * {@inheritDoc}
     */
    public function getTags()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTags', []);

        return parent::getTags();
    }

    /**
     * {@inheritDoc}
     */
    public function addTag($tag)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addTag', [$tag]);

        return parent::addTag($tag);
    }

    /**
     * {@inheritDoc}
     */
    public function removeTagAssociation($tag)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeTagAssociation', [$tag]);

        return parent::removeTagAssociation($tag);
    }

    /**
     * {@inheritDoc}
     */
    public function getSavedPosts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSavedPosts', []);

        return parent::getSavedPosts();
    }

    /**
     * {@inheritDoc}
     */
    public function addSavePost($savedPost)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addSavePost', [$savedPost]);

        return parent::addSavePost($savedPost);
    }

}
