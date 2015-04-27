<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\Websocket\MessageDispatcher;

use Ratchet\ConnectionInterface;
use Sulu\Component\Websocket\ConnectionContext\ConnectionContextInterface;
use Sulu\Component\Websocket\Exception\HandlerNotFoundException;

/**
 * Class MessageDispatcher.
 */
class MessageDispatcher implements MessageDispatcherInterface
{
    /**
     * @var MessageHandlerInterface[]
     */
    private $handler = array();

    /**
     * {@inheritdoc}
     */
    public function add($name, MessageHandlerInterface $handler)
    {
        $this->handler[$name] = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(
        ConnectionInterface $conn,
        $name,
        array $message,
        array $options,
        ConnectionContextInterface $context
    ) {
        if (!array_key_exists($name, $this->handler)) {
            throw new HandlerNotFoundException($name);
        }

        $result = $this->handler[$name]->handle($conn, $message, $context);

        return $result !== null ?
            array(
                'handler' => $name,
                'message' => $result,
                'options' => $options,
            ) : null;
    }
}
