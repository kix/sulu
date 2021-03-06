<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\LocationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Sulu\Bundle\LocationBundle\DependencyInjection\Compiler\GeolocatorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SuluLocationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GeolocatorPass());
    }
}
