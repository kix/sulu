<?php
/*
 * This file is part of the Sulu CMF.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\HttpCache\Handler;

use Sulu\Component\HttpCache\Handler\AggregateHandler;
use Symfony\Component\HttpFoundation\Response;
use Sulu\Component\Content\StructureInterface;
use Sulu\Component\HttpCache\HandlerInterface;

class AggregateHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HandlerInterface
     */
    private $handler;
    /**
     * @var HandlerInterface
     */
    private $handler1;

    /**
     * @var HandlerInterface
     */
    private $handler2;

    /**
     * @var StructureInterface
     */
    private $structure;

    /**
     * @var Response
     */
    private $response;

    public function setUp()
    {
        parent::setUp();

        $this->structure = $this->prophesize('Sulu\Component\Content\StructureInterface');
        $this->response = $this->prophesize('Symfony\Component\HttpFoundation\Response');

        $this->handler1 = $this->prophesize('Sulu\Component\HttpCache\HandlerUpdateResponseInterface')
            ->willImplement('Sulu\Component\HttpCache\HandlerInvalidateStructureInterface')
            ->willImplement('Sulu\Component\HttpCache\HandlerFlushInterface');
        $this->handler2 = $this->prophesize('Sulu\Component\HttpCache\HandlerUpdateResponseInterface')
            ->willImplement('Sulu\Component\HttpCache\HandlerInvalidateStructureInterface')
            ->willImplement('Sulu\Component\HttpCache\HandlerFlushInterface');

        $this->handler = new AggregateHandler(array(
            $this->handler1->reveal(),
            $this->handler2->reveal(),
        ));
    }

    public function testInvalidateStructure()
    {
        $this->handler1->invalidateStructure($this->structure->reveal())
            ->shouldBeCalled();
        $this->handler2->invalidateStructure($this->structure->reveal())
            ->shouldBeCalled();

        $this->handler->invalidateStructure($this->structure->reveal());
    }

    public function testUpdateResponse()
    {
        $this->handler1->updateResponse($this->response->reveal(), $this->structure->reveal())
            ->shouldBeCalled();
        $this->handler2->updateResponse($this->response->reveal(), $this->structure->reveal())
            ->shouldBeCalled();

        $this->handler->updateResponse($this->response->reveal(), $this->structure->reveal());
    }
}
