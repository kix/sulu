<?php

namespace DTL\Component\Content\Compat\Structure;

use Sulu\Component\Content\StructureManagerInterface;

class StructureManager implements StructureManagerInterface
{
    public function __construct(StructureFactoryInterface $factory)
    {
    }

    /**
     * Returns structure for given key and type
     * @param string $key
     * @param string $type
     * @return StructureInterface
     */
    public function getStructure($key, $type = Structure::TYPE_PAGE)
    {
        $structure = $this->structureFactory->getStructure($type, $key);

        $compatStructure = new Structure($structure);

        return $compatStructure;
    }

    /**
     * Return all the structures of the given type
     * @param string $type
     * @return StructureInterface[]
     */
    public function getStructures($type = Structure::TYPE_PAGE)
    {
    }


    /**
     * add dynamically an extension to structures
     * @param StructureExtensionInterface $extension
     * @param string $template default is all templates
     */
    public function addExtension(StructureExtensionInterface $extension, $template = 'all')
    {
    }

    /**
     * Returns extensions for structure
     * @param string $key
     * @return StructureExtensionInterface[]
     */
    public function getExtensions($key)
    {
    }

    /**
     * Indicates that the structure has a extension
     * @param string $key
     * @param string $name
     * @return boolean
     */
    public function hasExtension($key, $name)
    {
    }

    /**
     * Returns a extension
     * @param string $key
     * @param string $name
     * @return StructureExtensionInterface
     */
    public function getExtension($key, $name)
    {
    }
}