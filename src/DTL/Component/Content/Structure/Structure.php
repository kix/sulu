<?php

/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace DTL\Component\Content\Structure;

use DTL\Component\Content\Structure\Property;

class Structure extends Item
{
    /**
     * The resource from which this structure was loaded
     * (useful for debugging)
     *
     * @var string
     */
    public $resource;

    /**
     * Properties for this structure
     *
     * @var Property
     */
    public $properties = array();

    public function __set($field, $value)
    {
        throw new \InvalidArgumentException(sprintf(
            'Property "%s" does not exist on "%s"',
            $field, get_class($this)
        ));
    }

    /**
     * Return the named property
     *
     * @return string $name
     */
    public function getProperty($name)
    {
        if (!isset($this->properties[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown property "%s" in structure loaded from: "%s". Properties: "%s"',
                 $name, $this->resource, implode('", "', array_keys($this->properties))
            ));
        }

        return $this->properties[$name];
    }

    /**
     * Return true if this structure has the named property, false
     * if it does not.
     *
     * @param string $name
     */
    public function hasProperty($name)
    {
        return isset($this->properties[$name]);
    }

    /**
     * Return all the localized properties
     *
     * @return Property[]
     */
    public function getLocalizedProperties()
    {
        return array_filter($this->properties, function (Property $property) {
            return $property->localized === true;
        });
    }

    /**
     * Return all the non-localized properties
     *
     * @return Property[]
     */
    public function getNonLocalizedProperties()
    {
        return array_filter($this->properties, function (Property $property) {
            return $property->localized === false;
        });
    }
}
