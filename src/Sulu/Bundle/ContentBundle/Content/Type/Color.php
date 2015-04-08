<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ContentBundle\Content\Type;

use Sulu\Component\Content\Type\SimpleContentType;

/**
 * ContentType for Color
 */
class Color extends SimpleContentType
{
    private $template;

    public function __construct($template)
    {
        parent::__construct('Color', '');

        $this->template = $template;
    }

    /**
     * returns a template to render a form
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}