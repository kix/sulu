<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\Content\Type;

class ContentTypeManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $container;

    public function setUp()
    {
        $this->container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $this->manager = new ContentTypeManager($this->container);

        $this->manager->mapAliasToServiceId('content_1.alias', 'content_1.service.id');
        $this->manager->mapAliasToServiceId('content_2.alias', 'content_2.service.id');
    }

    public function testGetContentType()
    {
        $this->container->expects($this->once())
            ->method('get')
            ->with('content_1.service.id');

        $this->manager->get('content_1.alias');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage has not been registered
     */
    public function testGetContentTypeNotRegistered()
    {
        $this->manager->get('invalid.alias');
    }

    public function provideHas()
    {
        return array(
            array('content_1.alias', true),
            array('invalid.alias', false),
        );
    }

    /**
     * @dataProvider provideHas
     */
    public function testHas($alias, $expected)
    {
        $res = $this->manager->has($alias);
        $this->assertEquals($expected, $res);
    }
}
