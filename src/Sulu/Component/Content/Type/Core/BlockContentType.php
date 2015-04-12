<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\Content\Type\Core;

use PHPCR\NodeInterface;
use PHPCR\RepositoryException;
use Sulu\Component\Content\Type\ComplexContentType;
use Sulu\Component\Content\Type\ContentTypeInterface;
use Sulu\Component\Content\Type\ContentTypeManagerInterface;
use Sulu\Component\Content\Exception\UnexpectedPropertyType;
use Sulu\Component\Content\Structure\Property;
use Sulu\Component\Content\Document\Property\PropertyInterface;
use Sulu\Component\Content\Document\Property\Property as ValueProperty;
use Sulu\Component\Content\Structure\Block\BlockProperty;

/**
 * content type for block
 */
class BlockContentType extends ComplexContentType
{
    /**
     * @var ContentTypeManagerInterface
     */
    private $contentTypeManager;

    /**
     * template for form generation
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $languageNamespace;

    public function __construct(ContentTypeManagerInterface $contentTypeManager, $template, $languageNamespace)
    {
        $this->contentTypeManager = $contentTypeManager;
        $this->template = $template;
        $this->languageNamespace = $languageNamespace;
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return ContentTypeInterface::PRE_SAVE;
    }

    /**
     * {@inheritDoc}
     */
    public function read(
        NodeInterface $node,
        PropertyInterface $property,
        $webspaceKey,
        $languageCode,
        $segmentKey
    ) {
        $structureProperty = $property->getStructureProperty();

        var_dump($structureProperty);die();;
        /** @var BlockPropertyInterface $blockProperty */
        $blockProperty = $structureProperty;
        while (!$blockProperty instanceof BlockProperty) {
            $blockProperty = $blockProperty->getProperty();
        }

        // init properties
        $typeProperty = new Property('type', '', 'text_line');
        $lengthProperty = new Property('length', '', 'text_line');

        // load length
        $contentType = $this->contentTypeManager->get($lengthProperty->getContentTypeName());
        $contentType->read(
            $node,
            new BlockPropertyWrapper($lengthProperty, $property),
            $webspaceKey,
            $languageCode,
            $segmentKey
        );
        $len = $lengthProperty->getValue();

        for ($i = 0; $i < $len; $i++) {
            // load type
            $contentType = $this->contentTypeManager->get($typeProperty->getContentTypeName());
            $contentType->read(
                $node,
                new BlockPropertyWrapper($typeProperty, $property, $i),
                $webspaceKey,
                $languageCode,
                $segmentKey
            );

            $blockPropertyType = $blockProperty->initProperties($i, $typeProperty->getValue());

            /** @var PropertyInterface $subProperty */
            foreach ($blockPropertyType->getChildProperties() as $subProperty) {
                $contentType = $this->contentTypeManager->get($subProperty->getContentTypeName());
                $contentType->read(
                    $node,
                    new BlockPropertyWrapper($subProperty, $property, $i),
                    $webspaceKey,
                    $languageCode,
                    $segmentKey
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasValue(
        NodeInterface $node,
        PropertyInterface $property,
        $webspaceKey,
        $languageCode,
        $segmentKey
    ) {
        /** @var BlockPropertyInterface $blockProperty */
        $blockProperty = $property;
        while (!($blockProperty instanceof BlockPropertyInterface)) {
            $blockProperty = $blockProperty->getProperty();
        }

        // init properties
        $lengthProperty = new Property('length', '', 'text_line');
        $lengthBlockProperty = new BlockPropertyWrapper($lengthProperty, $property);
        $contentType = $this->contentTypeManager->get($lengthProperty->getContentTypeName());

        return $contentType->hasValue($node, $lengthBlockProperty, $webspaceKey, $languageCode, $segmentKey);
    }

    /**
     * {@inheritDoc}
     */
    public function readForPreview(
        $data,
        PropertyInterface $property,
        $webspaceKey,
        $languageCode,
        $segmentKey
    ) {
        /** @var BlockPropertyInterface $blockProperty */
        $blockProperty = $property;
        while (!($blockProperty instanceof BlockPropertyInterface)) {
            $blockProperty = $blockProperty->getProperty();
        }

        $len = sizeof($data);

        for ($i = 0; $i < $len; $i++) {
            $blockPropertyType = $blockProperty->initProperties($i, $data[$i]['type']);

            /** @var PropertyInterface $subProperty */
            foreach ($blockPropertyType->getChildProperties() as $subProperty) {
                if (isset($data[$i][$subProperty->getName()])) {
                    $contentType = $this->contentTypeManager->get($subProperty->getContentTypeName());
                    $contentType->readForPreview(
                        $data[$i][$subProperty->getName()],
                        $subProperty,
                        $webspaceKey,
                        $languageCode,
                        $segmentKey
                    );
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function write(
        NodeInterface $node,
        PropertyInterface $property,
        $userId,
        $webspaceKey,
        $languageCode,
        $segmentKey
    ) {
        $blockProperty = $property->getStructureProperty();
        $blockPropertyName = $property->getName();

        $data = $property->getValue();
        if (false === $blockProperty->getIsMultiple()) {
            $data = array($data);
        }

        $data = array_filter($data);
        $dataLength = count($data);

        $node->setProperty(
            $this->encodeBlockPropertyName($blockPropertyName, 'length'),
            $dataLength
        );

        foreach ($data as $i => $blocks) {
            foreach ($blocks as $blockData) {

                $blockTypeName = $blockData['type'];
                $node->setProperty(
                    $this->encodeBlockPropertyName($blockPropertyName, 'type', $i),
                    $blockTypeName
                );

                $blockType = $blockProperty->getBlockType($blockTypeName);

                foreach ($blockType->getChildProperties() as $blockTypeProperty) {
                    $blockTypeData = $blockData[$blockTypeProperty->getName()];
                    $this->writeProperty(
                        $property,
                        $blockTypeProperty,
                        $data,
                        $i,
                        $node,
                        $userId,
                        $webspaceKey,
                        $languageCode,
                        $segmentKey
                    );
                }
            }
        }
    }

    /**
     * write a property to node
     */
    private function writeProperty(
        PropertyInterface $blockProperty,
        Property $blockTypeProperty,
        $data,
        $index,
        NodeInterface $node,
        $userId,
        $webspaceKey,
        $languageCode,
        $segmentKey
    ) {
        // save sub property
        $contentType = $this->contentTypeManager->get($blockTypeProperty->getContentTypeName());
        $property = new ValueProperty(
            $this->encodeBlockPropertyName(
                $blockProperty->getName(),
                $blockTypeProperty->getName(),
                $index
            ),
            $data
        );


        // TODO find a better why for change Types (same hack is used in ContentMapper:save )
        $contentType->remove(
            $node,
            $blockProperty,
            $webspaceKey,
            $languageCode,
            $segmentKey
        );
        $contentType->write(
            $node,
            $property,
            $userId,
            $webspaceKey,
            $languageCode,
            $segmentKey
        );
    }

    /**
     * {@inheritDoc}
     */
    public function remove(
        NodeInterface $node,
        PropertyInterface $property,
        $webspaceKey,
        $languageCode,
        $segmentKey
    ) {
        foreach ($node->getProperties($property->getName().'-*')  as $nodeProperty) {
            $node->getProperty($nodeProperty->getName())->remove();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * {@inheritDoc}
     */
    public function getViewData(PropertyInterface $property)
    {
        return $this->prepareData(
            $property,
            function (ContentTypeInterface $contentType, $property) {
                return $contentType->getViewData($property);
            },
            false
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getContentData(PropertyInterface $property)
    {
        return $this->prepareData(
            $property,
            function (ContentTypeInterface $contentType, $property) {
                return $contentType->getContentData($property);
            }
        );
    }

    /**
     * Returns prepared data from property
     * use callback to prepare data foreach property function($contentType, $property)
     * @param PropertyInterface $property
     * @param callable $dataCallback
     * @param bool $returnType
     * @return array
     */
    private function prepareData(PropertyInterface $property, callable $dataCallback, $returnType = true)
    {
        /** @var BlockPropertyInterface $blockProperty */
        $blockProperty = $property;
        while (!($blockProperty instanceof BlockPropertyInterface)) {
            $blockProperty = $blockProperty->getProperty();
        }

        $data = array();
        for ($i = 0; $i < $blockProperty->getLength(); $i++) {
            $blockPropertyType = $blockProperty->getProperties($i);

            if ($returnType) {
                $type = $blockPropertyType->getName();
                $data[$i] = array('type' => $type);
            }

            foreach ($blockPropertyType->getChildProperties() as $childProperty) {
                $contentType = $this->contentTypeManager->get($childProperty->getContentTypeName());
                $data[$i][$childProperty->getName()] = $dataCallback($contentType, $childProperty);
            }
        }

        if (!$property->getIsMultiple() && count($data) > 0) {
            $data = $data[0];
        }

        return $data;
    }

    private function encodeBlockPropertyName($blockName, $propertyName, $index = null)
    {
        return $blockName . '-' .$propertyName . ($index !== null ? '#' . $index : '');
    }
}
