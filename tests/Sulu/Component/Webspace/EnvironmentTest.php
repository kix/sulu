<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\Environment;

use Sulu\Component\Webspace\Environment;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->environment = new Environment();
        $this->url = $this->prophesize('Sulu\Component\Webspace\Url');
    }

    public function testToArray()
    {
        $expected = array(
            'type' => 'foo',
            'urls' => array(
                array('asd'),
            ),
        );

        $this->url->toArray()->willReturn(array('asd'));
        $this->environment->addUrl($this->url->reveal());
        $this->environment->setType($expected['type']);

        $this->assertEquals($expected, $this->environment->toArray());
    }
}
