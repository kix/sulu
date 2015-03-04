<?php

/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace DTL\Component\Content\Property;

interface PropertyTypeRegistryInterface
{
    /**
     * Return the content type with the given name
     *
     * @param string $name
     *
     * @return ContentTypeInterface
     */
    public function getProperty($name);
}