<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace DTL\Component\Content\FrontView;

use Symfony\Component\Form\Exception\BadMethodCallException;

/**
 * The FrontView object is the object which represents a content type
 * within the frontend template.
 *
 * It is the analogue of the Symfony\Component\Form\FormView
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class FrontView implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * The contents primary value
     *
     * @var mixed
     */
    private $value;

    /**
     * Attributes for this content view
     *
     * @var array
     */
    private $attributes;

    /**
     * The parent view.
     *
     * @var FrontView
     */
    private $parent;

    /**
     * The child views.
     *
     * @var FormView[]
     */
    private $children = array();

    public function __construct(FrontView $parent = null)
    {
        $this->parent = $parent;
    }

    public function __toString()
    {
        if (!is_scalar($this->value)) {
            return '';
        }

        return (string) $this->value;
    }

    /**
     * Return the primary value for this content view
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the primary value for this content view
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Return the attribute with the specified name
     *
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name)
    {
        return $this->attributes[$name];
    }

    /**
     * Set an attribute of name with the specified value
     *
     * @param string $name
     * @param mixed $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Set the iteratable / array accessible children for this node
     *
     * @param array|itreator $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * Return the children collection for this view. Each
     * child should be an instance of FrontView
     *
     * @return array|iterator
     */
    public function getChildren() 
    {
        return $this->children;
    }

    /**
     * Return the parent content view
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Returns a child by name (implements \ArrayAccess).
     *
     * @param string $name The child name
     *
     * @return FormView The child view
     */
    public function offsetGet($name)
    {
        return $this->children[$name];
    }

    /**
     * Returns whether the given child exists (implements \ArrayAccess).
     *
     * @param string $name The child name
     *
     * @return bool Whether the child view exists
     */
    public function offsetExists($name)
    {
        return isset($this->children[$name]);
    }

    /**
     * Implements \ArrayAccess.
     *
     * @throws BadMethodCallException always as setting a child by name is not allowed
     */
    public function offsetSet($name, $value)
    {
        throw new BadMethodCallException('Cannot set a child directly, use setChildren()');
    }

    /**
     * Removes a child (implements \ArrayAccess).
     *
     * @param string $name The child name
     */
    public function offsetUnset($name)
    {
        unset($this->children[$name]);
    }

    /**
     * Returns an iterator to iterate over children (implements \IteratorAggregate).
     *
     * @return \ArrayIterator The iterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->children);
    }

    /**
     * Implements \Countable.
     *
     * @return int The number of children views
     */
    public function count()
    {
        return count($this->children);
    }
}
