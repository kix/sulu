<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ContentBundle\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Sulu\Component\Content\StructureInterface;
use Sulu\Component\Content\Mapper\ContentMapperRequest;
use Behat\Gherkin\Node\TableNode;
use Sulu\Bundle\ContentBundle\Behat\BaseStructureContext;

/**
 * Behat context class for the ContentBundle
 */
class ContentContext extends BaseStructureContext implements SnippetAcceptingContext
{
    /**
     * @Given there exists a page template :arg1 with the following property configuration
     */
    public function thereExistsAPageTemplateWithTheFollowingPropertyConfiguration($arg1, PyStringNode $string)
    {
        $template = <<<EOT
<?xml version="1.0" ?>

<template xmlns="http://schemas.sulu.io/template/template"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xsi:schemaLocation="http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd"
          >

    <key>%s</key>

    <view>SuluTestBundle::content_test</view>
    <controller>SuluWebsiteBundle:Default:index</controller>
    <cacheLifetime>2400</cacheLifetime>

    <meta>
        <title lang="de">%s</title>
        <title lang="en">%s</title>
    </meta>

    <properties>
        <property name="title" type="text_line" mandatory="true">
            <meta>
                <title lang="de">Tier</title>
                <title lang="en">Animals</title>
            </meta>

            <tag name="sulu.rlp.part"/>
        </property>

        <property name="url" type="resource_locator" mandatory="true">
            <meta>
                <title lang="de">Adresse</title>
                <title lang="en">Resourcelocator</title>
            </meta>

            <tag name="sulu.rlp"/>
        </property>

%s
    </properties>
</template>
EOT;

        $template = sprintf($template,
            $arg1, $arg1, $arg1, $string->getRaw()
        );

        $this->createStructureTemplate('page', $arg1, $template);
    }

    /**
     * @Given the following pages exist:
     */
    public function theFollowingPagesExist(TableNode $table)
    {
        $data = $table->getColumnsHash();

        $this->createStructures('page', $data);
    }

    /**
     * @Given I am editing a page of type :arg1
     */
    public function iAmEditingAPageOfType($arg1)
    {
        $request = ContentMapperRequest::create()
            ->setTemplateKey($arg1)
            ->setType('page')
            ->setWebspaceKey('sulu_io')
            ->setUserId($this->getUserId())
            ->setState(StructureInterface::STATE_PUBLISHED)
            ->setLocale('de')
            ->setData(array(
                'title' => 'Behat Test Content',
                'url' => '/behat-test-content',
            ));

        $page = $this->getContentMapper()->saveRequest($request);
        $this->visitPath('/admin/#content/contents/sulu_io/de/edit:' . $page->getUuid() . '/content');
        $this->getSession()->wait(5000, '$("#content-form").length');
        sleep(1); // wait one more second to avoid flaky tests
    }

    /**
     * @Then I should see the date picker
     */
    public function iShouldSeeTheDatePicker()
    {
        return $this->getSession()->evaluateScript('$(".datepicker").length');
    }

    /**
     * @Then I should see the color picker
     */
    public function iShouldSeeTheColorPicker()
    {
        return $this->getSession()->evaluateScript('$(".minicolors").length');
    }

    /**
     * @Then I click the first smart content filter icon
     */
    public function iClickTheFirstSmartContentFilterIcon()
    {
        $this->clickSelector('.smart-content-container .fa-filter');
    }

    /**
     * @Then I fill in CKEditor instance ":ckEditorId" with ":text"
     */
    public function iFillInTheCKEditorWith($ckEditorId, $text)
    {
        $this->getSession()->executeScript("CKEDITOR.instances['" . $ckEditorId . "'].insertHtml('" . $text ."');");
    }
}
