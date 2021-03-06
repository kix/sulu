<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\WebsiteBundle\DataCollector;

use Sulu\Component\Content\StructureInterface;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;

class SuluCollector extends DataCollector
{
    protected $requestAnalyzer;

    public function __construct(RequestAnalyzerInterface $requestAnalyzer)
    {
        $this->requestAnalyzer = $requestAnalyzer;
    }

    public function data($key)
    {
        return $this->data[$key];
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $requestAnalyzer = $this->requestAnalyzer;

        $webspace = $requestAnalyzer->getWebspace();
        $portal = $requestAnalyzer->getPortal();
        $segment = $requestAnalyzer->getSegment();

        $this->data['match_type'] = $requestAnalyzer->getMatchType();
        $this->data['redirect'] = $requestAnalyzer->getRedirect();
        $this->data['portal_url'] = $requestAnalyzer->getPortalUrl();

        if ($webspace) {
            $this->data['webspace'] = $webspace->toArray();
        }

        if ($portal) {
            $this->data['portal'] = $portal->toArray();
        }

        if ($segment) {
            $this->data['segment'] = $segment->toArray();
        }

        $this->data['localization'] = $requestAnalyzer->getCurrentLocalization();
        $this->data['resource_locator'] = $requestAnalyzer->getResourceLocator();
        $this->data['resource_locator_prefix'] = $requestAnalyzer->getResourceLocatorPrefix();

        $structure = null;
        if ($request->attributes->has('_route_params')) {
            $params = $request->attributes->get('_route_params');
            if (isset($params['structure'])) {
                /** @var StructureInterface $structureObject */
                $structureObject = $params['structure'];

                $structure = array(
                    'id' => $structureObject->getUuid(),
                    'path' => $structureObject->getPath(),
                    'nodeType' => $structureObject->getNodeType(),
                    'internal' => $structureObject->getInternal(),
                    'nodeState' => $structureObject->getNodeState(),
                    'published' => $structureObject->getPublished(),
                    'publishedState' => $structureObject->getPublishedState(),
                    'navContexts' => $structureObject->getNavContexts(),
                    'enabledShadowLanguages' => $structureObject->getEnabledShadowLanguages(),
                    'concreteLanguages' => $structureObject->getConcreteLanguages(),
                    'shadowOn' => $structureObject->getIsShadow(),
                    'shadowBaseLanguage' => $structureObject->getShadowBaseLanguage(),
                    'template' => $structureObject->getKey(),
                    'originTemplate' => $structureObject->getOriginTemplate(),
                    'hasSub' => $structureObject->getHasChildren(),
                    'creator' => $structureObject->getCreator(),
                    'changer' => $structureObject->getChanger(),
                    'created' => $structureObject->getCreated(),
                    'changed' => $structureObject->getChanged()
                );
            }
        }
        $this->data['structure'] = $structure;
    }

    public function getName()
    {
        return 'sulu';
    }
}
