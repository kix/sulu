<?php

namespace DTL\Bundle\ContentBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Replaces legacy services with compatibility layers
 */
class CompatPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->getParameter('dtl_content.compat')) {
            return;
        }

        $this->replaceStructureManager($container);
        $this->replaceContentMapper($container);
    }

    public function replaceStructureManager(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sulu.content.structure_manager')) {
            return;
        }

        $container->removeDefinition('sulu.content.structure_manager');
        $container->setAlias('sulu.content.structure_manager', 'dtl_content.compat.structure.structure_manager');
    }

    public function replaceContentMapper(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sulu.content.mapper')) {
            return;
        }

        $container->removeDefinition('sulu.content.mapper');
        $container->setAlias('sulu.content.mapper', 'dtl_content.compat.content_mapper');
    }
}