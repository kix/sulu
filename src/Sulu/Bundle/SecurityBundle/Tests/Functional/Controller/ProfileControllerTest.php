<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SecurityBundle\Tests\Functional\Controller;

use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class ProfileControllerTest extends SuluTestCase
{
    public function testChangeLanguageAction()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('POST', '/security/profile/change-language', array('locale' => 'de'));

        // check current instance
        $user = $client->getContainer()->get('security.context')->getToken()->getUser();
        $this->assertEquals('de', $user->getLocale());

        // check value in database
        $user = $this->getContainer()->get('test_user_provider')->loadUserByUsername('test');
        $this->assertEquals('de', $user->getLocale());
    }
}
