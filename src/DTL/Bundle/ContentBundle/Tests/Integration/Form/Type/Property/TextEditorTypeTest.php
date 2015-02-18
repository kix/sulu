<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace DTL\Bundle\ContentBundle\Tests\Integration\Form\Type\Property;

use DTL\Bundle\ContentBundle\Form\Type\Content\TextEditorType;

class TextEditorTypeTest extends AbstractPropertyTypeTestCase
{
    public function getType()
    {
        return new TextEditorType();
    }

    /**
     * {@inheritDoc}
     */
    public function provideFormView()
    {
        return array(
            array(
                array(
                    'god_mode' => false,
                    'tables_enabled' => true,
                    'links_enabled' => true,
                    'paste_from_word' => true,
                ),
                array(
                    'god_mode' => false,
                    'tables_enabled' => true,
                    'links_enabled' => true,
                    'paste_from_word' => true,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function provideFrontViewAttributes()
    {
        return array(
            array(
                array(
                ),
                array(
                ),
                array(
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function provideFrontViewValue()
    {
        return array(
            array(
                array(
                ),
                'Hello',
                'Hello',
            ),
            array(
                array(
                ),
                null,
                null,
            ),
        );
    }
}