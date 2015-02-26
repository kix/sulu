<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace DTL\Bundle\ContentBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DtlContentExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('phpcr_odm.xml');
        $loader->load('serializer.xml');
        $loader->load('form.xml');
        $loader->load('form_content_types.xml');
        $loader->load('routing_auto.xml');
        $loader->load('structure.xml');

        $this->processStructure($config['structure'], $container);
    }

    private function processStructure($config, ContainerBuilder $container)
    {
        $this->processPaths($config['paths'], $container);
    }

    private function processPaths($config, ContainerBuilder $container)
    {
        $typePaths = array();

        foreach ($config as $path) {
            $typePaths[$path['type']] = $path['path'];
        }

        $container->setParameter('dtl_content.structure.paths', $typePaths);
    }
}

