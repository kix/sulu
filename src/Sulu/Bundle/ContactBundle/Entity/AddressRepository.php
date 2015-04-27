<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ContactBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * AddressRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AddressRepository extends EntityRepository
{
    public function findById($id)
    {
        try {
            $qb = $this->createQueryBuilder('address')
                ->leftJoin('address.accountAddresses', 'accountAddresses')
                ->leftJoin('address.contactAddresses', 'contactAddresses')
                ->leftJoin('address.country', 'country')
                ->leftJoin('address.addressType', 'addressType')
                ->addSelect('accountAddresses')
                ->addSelect('contactAddresses')
                ->addSelect('country')
                ->addSelect('addressType')
                ->where('address.id = :id');

            $query = $qb->getQuery();
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
            $query->setParameter('id', $id);

            return $query->getSingleResult();
        } catch (NoResultException $ex) {
            return;
        }
    }

    public function findByAccountId($id)
    {
        try {
            $qb = $this->createQueryBuilder('address')
                ->leftJoin('address.accountAddresses', 'accountAddresses')
                ->leftJoin('address.contactAddresses', 'contactAddresses')
                ->leftJoin('address.country', 'country')
                ->leftJoin('address.addressType', 'addressType')
                ->leftJoin('accountAddresses.account', 'account')
                ->addSelect('accountAddresses')
                ->addSelect('contactAddresses')
                ->addSelect('country')
                ->addSelect('addressType')
                ->where('account.id = :id');

            $query = $qb->getQuery();
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
            $query->setParameter('id', $id);

            return $query->getResult();
        } catch (NoResultException $ex) {
            return;
        }
    }
}
