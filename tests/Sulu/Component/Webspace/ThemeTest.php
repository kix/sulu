<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\Theme;

use Sulu\Component\Webspace\Theme;

class ThemeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->theme = new Theme();
    }

    public function testToArray()
    {
        $expected = array(
            'key' => 'foo',
            'excludedTemplates' => array('portal_key'),
        );

        $this->theme->setKey($expected['key']);
        $this->theme->setExcludedTemplates($expected['excludedTemplates']);

        $this->assertEquals($expected, $this->theme->toArray());
    }
}
