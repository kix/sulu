<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ContentBundle\Document;

use Sulu\Component\DocumentManager\Behavior\TitleBehavior;

class HomeDocument extends BasePageDocument implements TitleBehavior
{
    public function getResourceSegment()
    {
        return '/';
    }
}