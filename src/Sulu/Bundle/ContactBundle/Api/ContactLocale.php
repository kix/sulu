<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ContactBundle\Api;

use Doctrine\Entity;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Component\Rest\ApiWrapper;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * The ContactLocale class which will be exported to the API
 *
 * @package Sulu\Bundle\ContactBundle\Api
 * @ExclusionPolicy("all")
 */
class ContactLocale extends ApiWrapper
{
    /**
     * @param ContactLocale $contactLocale
     */
    public function __construct(ContactLocale $contactLocale)
    {
        $this->entity = $contactLocale;
    }

    /**
     * Returns the id of the product
     *
     * @return int
     * @VirtualProperty
     * @SerializedName("id")
     */
    public function getId()
    {
        return $this->entity->getId();
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return ContactLocale
     */
    public function setLocale($locale)
    {
        $this->entity->setLocale($locale);

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("locale")
     */
    public function getLocale()
    {
        return $this->entity->getLocale();
    }
}
