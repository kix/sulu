<?php


/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DTL\Bundle\ContentBundle\Document;

use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Cmf\Component\RoutingAuto\Model\AutoRouteInterface;

/**
 * Sulu Route class
 */
class Route implements RouteObjectInterface, AutoRouteInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * Path of this route
     *
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * The referenced content object
     *
     * @var object
     */
    private $content;

    /**
     * @var object
     */
    private $parent;

    /**
     * @var boolean
     */
    private $history;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var object[]
     */
    private $children;

    /**
     * @var \DateTime
     */
    private $created;

    private $autoRouteTag;

    /**
     * Get the UUID of this route
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the object this url points to
     *
     * @param mixed $object A content object that can be persisted by the
     *                      storage layer.
     */
    public function setContent($object)
    {
        $this->content = $object;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getParent() 
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getName() 
    {
        return $this->name;
    }
    

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getChildren() 
    {
        return $this->children;
    }

    public function getRouteKey()
    {
        return null;
    }

    public function getCreated() 
    {
        return $this->created;
    }
    
    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getAutoRouteTag() 
    {
        return $this->autoRouteTag;
    }
    
    public function setAutoRouteTag($autoRouteTag)
    {
        $this->autoRouteTag = $autoRouteTag;
    }

    public function setType($type)
    {
        switch ($type) {
            case AutoRouteInterface::TYPE_PRIMARY:
                $this->history = false;
                return;
            case AutoRouteInterface::TYPE_REDIRECT:
                $this->history = true;
                return;
        }

        throw new \InvalidArgumentException(sprintf(
            'Unknown auto route type "%s" pass to "%s#setType"',
            $type,
            get_class($this)
        ));
    }

    public function getType()
    {
        if (true === $this->history) {
            return AutoRouteInterface::TYPE_REDIRECT;
        }

        return AutoRouteInterface::TYPE_PRIMARY;
    }

    public function getRedirectTarget() 
    {
        throw new \BadMethodCallException('Not implemented, we infer the redirect route from the content');
    }
    
    public function setRedirectTarget(AutoRouteInterface $redirectTarget)
    {
        // do nothing
    }

    public function getPath() 
    {
        return $this->path;
    }
    
    public function setPath($path)
    {
        $this->path = $path;
    }
    
}
