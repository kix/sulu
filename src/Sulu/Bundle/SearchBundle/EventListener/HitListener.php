<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SearchBundle\EventListener;

use Massive\Bundle\SearchBundle\Search\Event\HitEvent;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;

/**
 * Listen to for new hits. If document instance of structure
 * prefix the current resource locator prefix to the URL
 */
class HitListener
{
    /**
     * @var RequestAnalyzerInterface
     */
    private $requestAnalyzer;

    public function __construct(RequestAnalyzerInterface $requestAnalyzer)
    {
        $this->requestAnalyzer = $requestAnalyzer;
    }

    /**
     * Prefix url of document with current resourcelocator prefix
     * @param HitEvent $event
     */
    public function onHit(HitEvent $event)
    {
        if (false === $event->getDocumentReflection()->isSubclassOf('Sulu\Component\Content\Structure')) {
            return;
        }

        $document = $event->getHit()->getDocument();
        $url = sprintf(
            '%s/%s',
            rtrim($this->requestAnalyzer->getResourceLocatorPrefix(), '/'),
            ltrim($document->getUrl(), '/')
        );
        $document->setUrl($url);
    }
}
