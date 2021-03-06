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
use Sulu\Bundle\ContactBundle\Entity\AccountAddress as AccountAddressEntity;
use Sulu\Bundle\ContactBundle\Entity\Address as AddressEntity;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Component\Rest\ApiWrapper;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Groups;

/**
 * The AccountAddress class which will be exported to the API
 *
 * @package Sulu\Bundle\ContactBundle\Api
 * @ExclusionPolicy("all")
 */
class AccountAddress extends ApiWrapper
{
    /**
     */
    public function __construct(AccountAddressEntity $address)
    {
        $this->entity = $address;
    }

    /**
     * @return int
     * @VirtualProperty
     * @SerializedName("id")
     * @Groups({"fullAccount"})
     */
    public function getId()
    {
        return $this->entity->getId();
    }

    /**
     * Set main
     *
     * @param boolean $main
     * @return AccountAddress
     */
    public function setMain($main)
    {
        $this->entity->setMain($main);

        return $this;
    }

    /**
     * Get main
     *
     * @return boolean
     * @VirtualProperty
     * @SerializedName("main")
     * @Groups({"fullAccount"})
     */
    public function getMain()
    {
        return $this->entity->getMain();
    }

    /**
     * Set address
     *
     * @param AddressEntity $address
     * @return AccountAddress
     */
    public function setAddress(AddressEntity $address)
    {
        $this->entity->setAddress($address);

        return $this;
    }

    /**
     * Get address
     *
     * @return AddressEntity
     * @VirtualProperty
     * @SerializedName("address")
     * @Groups({"fullAccount"})
     */
    public function getAddress()
    {
        $adr =  $this->entity->getAddress();

        return new AddressEntity($adr);
    }
}
