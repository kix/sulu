<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\MediaBundle\Entity;

use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * CollectionRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CollectionRepository extends NestedTreeRepository implements CollectionRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findCollectionById($id)
    {
        $dql = sprintf(
            'SELECT n, collectionMeta, defaultMeta, collectionType, collectionParent, parentMeta, collectionChildren
                 FROM %s AS n
                        LEFT JOIN n.meta AS collectionMeta
                        LEFT JOIN n.defaultMeta AS defaultMeta
                        LEFT JOIN n.type AS collectionType
                        LEFT JOIN n.parent AS collectionParent
                        LEFT JOIN n.children AS collectionChildren
                        LEFT JOIN collectionParent.meta AS parentMeta
                 WHERE n.id = :id',
            $this->_entityName
        );

        $query = new Query($this->_em);
        $query->setDQL($dql);
        $query->setParameter('id', $id);
        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
        $result = $query->getResult();

        if (sizeof($result) === 0) {
            return;
        }

        return $result[0];
    }

    /**
     * {@inheritdoc}
     */
    public function findCollectionSet($depth = 0, $filter = array(), Collection $collection = null, $sortBy = array())
    {
        try {
            $dql = sprintf(
                'SELECT n, collectionMeta, defaultMeta, collectionType, collectionParent, parentMeta, collectionChildren
                 FROM %s AS n
                        LEFT OUTER JOIN n.meta AS collectionMeta
                        LEFT JOIN n.defaultMeta AS defaultMeta
                        LEFT JOIN n.type AS collectionType
                        LEFT JOIN n.parent AS collectionParent
                        LEFT JOIN n.children AS collectionChildren
                        LEFT JOIN collectionParent.meta AS parentMeta
                 WHERE (n.depth <= :depth + :maxDepth OR collectionChildren.depth <= :maxDepthPlusOne)',
                $this->_entityName
            );

            if ($collection !== null) {
                $dql .= ' AND n.lft BETWEEN :lft AND :rgt AND n.id != :id';
            }

            if (array_key_exists('search', $filter) && $filter['search'] !== null) {
                $dql .= ' AND collectionMeta.title LIKE :search';
            }

            if (array_key_exists('locale', $filter)) {
                $dql .= ' AND (collectionMeta.locale = :locale OR defaultMeta != :locale)';
            }

            if ($sortBy !== null && is_array($sortBy) && sizeof($sortBy) > 0) {
                $orderBy = array();
                foreach ($sortBy as $column => $order) {
                    $orderBy[] = 'collectionMeta.' . $column . ' ' . (strtolower($order) === 'asc' ? 'ASC' : 'DESC');
                }
                $dql .= ' ORDER BY ' . implode(', ', $orderBy);
            }

            $query = new Query($this->_em);
            $query->setDQL($dql);
            $query->setParameter('maxDepth', intval($depth));
            $query->setParameter('maxDepthPlusOne', intval($depth) + 1);
            $query->setParameter('depth', $collection !== null ? $collection->getDepth() : 0);

            if ($collection !== null) {
                $query->setParameter('lft', $collection->getLft());
                $query->setParameter('rgt', $collection->getRgt());
                $query->setParameter('id', $collection->getId());
            }

            if (array_key_exists('search', $filter) && $filter['search'] !== null) {
                $query->setParameter('search', '%' . $filter['search'] . '%');
            }

            if (array_key_exists('limit', $filter)) {
                $query->setMaxResults($filter['limit']);
            }

            if (array_key_exists('offset', $filter)) {
                $query->setFirstResult($filter['offset']);
            }

            if (array_key_exists('locale', $filter)) {
                $query->setParameter('locale', $filter['locale']);
            }

            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

            return new Paginator($query);
        } catch (NoResultException $ex) {
            return array();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findCollections($filter = array(), $limit = null, $offset = null, $sortBy = array())
    {
        list($parent, $depth, $search) = array(
            isset($filter['parent']) ? $filter['parent'] : null,
            isset($filter['depth']) ? $filter['depth'] : null,
            isset($filter['search']) ? $filter['search'] : null,
        );

        try {
            $qb = $this->createQueryBuilder('collection')
                ->leftJoin('collection.meta', 'collectionMeta')
                ->leftJoin('collection.defaultMeta', 'defaultMeta')
                ->leftJoin('collection.type', 'type')
                ->leftJoin('collection.parent', 'parent')
                ->leftJoin('collection.children', 'children')
                /*
                ->leftJoin('collection.creator', 'creator')
                ->leftJoin('creator.contact', 'creatorContact')
                ->leftJoin('collection.changer', 'changer')
                ->leftJoin('changer.contact', 'changerContact')
                */
                ->addSelect('collectionMeta')
                ->addSelect('defaultMeta')
                ->addSelect('type')
                ->addSelect('parent')
                ->addSelect('children');
                /*
                ->addSelect('creator')
                ->addSelect('changer')
                ->addSelect('creatorContact')
                ->addSelect('changerContact')
                */

            if ($sortBy !== null && is_array($sortBy) && sizeof($sortBy) > 0) {
                foreach ($sortBy as $column => $order) {
                    $qb->addOrderBy('collectionMeta.' . $column, strtolower($order) === 'asc' ? 'ASC' : 'DESC');
                }
            }
            if ($parent !== null) {
                $qb->andWhere('parent.id = :parent');
            }
            if ($depth !== null) {
                $qb->andWhere('collection.depth <= :depth');
            }
            if ($search !== null) {
                $qb->andWhere('collectionMeta.title LIKE :search');
            }
            if ($offset !== null) {
                $qb->setFirstResult($offset);
            }
            if ($limit !== null) {
                $qb->setMaxResults($limit);
            }

            $query = $qb->getQuery();
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
            if ($parent !== null) {
                $query->setParameter('parent', $parent);
            }
            if ($depth !== null) {
                $query->setParameter('depth', intval($depth));
            }
            if ($search !== null) {
                $query->setParameter('search', '%' . $search . '%');
            }

            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

            return new Paginator($query);
        } catch (NoResultException $ex) {
            return;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findCollectionBreadcrumbById($id)
    {
        try {
            $sql = sprintf(
                'SELECT n, collectionMeta, defaultMeta
                 FROM %s AS p,
                      %s AS n
                        LEFT JOIN n.meta AS collectionMeta
                        LEFT JOIN n.defaultMeta AS defaultMeta
                 WHERE p.id = :id AND p.lft > n.lft AND p.rgt < n.rgt
                 ORDER BY n.lft',
                $this->_entityName,
                $this->_entityName
            );

            $query = new Query($this->_em);
            $query->setDQL($sql);
            $query->setParameter('id', $id);
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

            return $query->getResult();
        } catch (NoResultException $ex) {
            return array();
        }
    }
}
