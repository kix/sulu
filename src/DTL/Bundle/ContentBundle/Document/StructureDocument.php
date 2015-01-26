<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace DTL\Bundle\ContentBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * Base Structure class.
 *
 * Page and Snippet Documents will extend this class.
 *
 * @PHPCR\MappedSuperclass(
 *     translator="attribute"
 * )
 */
class StructureDocument
{
    /**
     * @PHPCR\Locale()
     */
    private $locale;

    /**
     * @PHPCR\NodeName()
     */
    private $name;

    /**
     * @PHPCR\ParentDocument()
     */
    private $parent;

    /**
     * @PHPCR\Children()
     */
    private $children;

    /**
     * @PHPCR\String(translated=true, property="sulu:title", translated=true)
     */
    private $title;

    /**
     * @PHPCR\String(translated=true, property="sulu:template", translated=true)
     */
    private $template;

    /**
     * @PHPCR\Long(property="sulu:creator")
     */
    private $creator;

    /**
     * @PHPCR\Long(property="sulu:changer")
     */
    private $changer;

    /**
     * @PHPCR\Date(property="sulu:created")
     */
    private $created;

    /**
     * @PHPCR\Date(property="sulu:updated")
     */
    private $updated;

    /**
     * Content data.
     * This is not mapped, it is serialized by event listener.
     *
     * @see DTL\Component\Content\EventSubscriber\PhpcrOdmStructureSubscriber
     */
    private $contentData = array();

    public function getParent() 
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getChildren() 
    {
        return $this->children;
    }
    
    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function getTitle() 
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTemplate() 
    {
        return $this->template;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getCreator() 
    {
        return $this->creator;
    }
    
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }
    
    public function getChanger() 
    {
        return $this->changer;
    }
    
    public function setChanger($changer)
    {
        $this->changer = $changer;
    }

    public function getCreated() 
    {
        return $this->created;
    }
    
    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated() 
    {
        return $this->updated;
    }
    
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    public function getContentData()
    {
        return $this->contentData;
    }

    public function setContentData($contentData)
    {
        $this->contentData = $contentData;
    }

    public function getName() 
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
}