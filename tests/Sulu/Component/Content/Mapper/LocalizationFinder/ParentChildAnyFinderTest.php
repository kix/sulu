<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\Content\Mapper\LocalizationFinder;

class ParentChildAnyFinderTest extends \PHPUnit_Framework_TestCase
{
    private $node;
    private $finder;

    public function setUp()
    {
        parent::setUp();
        $this->node = $this->prophesize('PHPCR\NodeInterface');
        $webspaceManager = $this->prophesize('Sulu\Component\Webspace\Manager\WebspaceManagerInterface');

        $this->finder = new ParentChildAnyFinder($webspaceManager->reveal(), 'prefix', 'internal');
    }

    public function testSupportsNonNullWebspace()
    {
        $res = $this->finder->supports($this->node->reveal(), 'foobar', 'webspace');
        $this->assertTrue($res);
    }

    public function testSupportsNullWebspace()
    {
        $res = $this->finder->supports($this->node->reveal(), 'foobar', null);
        $this->assertFalse($res);
    }
}
