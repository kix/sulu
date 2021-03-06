<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SearchBundle\Tests\Functional;

use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\Filesystem\Filesystem;
use Sulu\Bundle\TestBundle\Testing\SuluWebsiteTestCase;

class WebsiteIntegrationTest extends BaseTestCase
{
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = $this->createWebsiteClient();
        $this->indexStructure('Structure', '/structure');
    }

    public function testIntegration()
    {
        $this->client->request('GET', '/de/search?query=Structure');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
