<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\Webspace;

use Sulu\Component\Localization\Localization;
use Sulu\Component\Util\ArrayableInterface;

/**
 * This class represents the information for a given URL.
 */
class PortalInformation implements ArrayableInterface
{
    /**
     * The type of the match.
     *
     * @var int
     */
    private $type;

    /**
     * The webspace for this portal information.
     *
     * @var Webspace
     */
    private $webspace;

    /**
     * The portal for this portal information.
     *
     * @var Portal
     */
    private $portal;

    /**
     * The localization for this portal information.
     *
     * @var Localization
     */
    private $localization;

    /**
     * The segment for this portal information.
     *
     * @var Segment
     */
    private $segment;

    /**
     * The url for this portal information.
     *
     * @var string
     */
    private $url;

    /**
     * The analyticsKey for this portal information.
     *
     * @var string
     */
    private $analyticsKey;

    /**
     * @var string The url to redirect to
     */
    private $redirect;

    public function __construct(
        $type,
        Webspace $webspace = null,
        Portal $portal = null,
        Localization $localization = null,
        $url,
        Segment $segment = null,
        $redirect = null,
        $analyticsKey = null
    ) {
        $this->setType($type);
        $this->setWebspace($webspace);
        $this->setPortal($portal);
        $this->setLocalization($localization);
        $this->setSegment($segment);
        $this->setUrl($url);
        $this->setRedirect($redirect);
        $this->setAnalyticsKey($analyticsKey);
    }

    /**
     * Sets the localization for this PortalInformation.
     *
     * @param Localization $localization
     */
    public function setLocalization($localization)
    {
        $this->localization = $localization;
    }

    /**
     * Returns the localization for this PortalInformation.
     *
     * @return Localization
     */
    public function getLocalization()
    {
        return $this->localization;
    }

    /**
     * Sets the portal for this PortalInformation.
     *
     * @param \Sulu\Component\Webspace\Portal $portal
     */
    public function setPortal($portal)
    {
        $this->portal = $portal;
    }

    /**
     * Returns the portal for this PortalInformation.
     *
     * @return \Sulu\Component\Webspace\Portal
     */
    public function getPortal()
    {
        return $this->portal;
    }

    /**
     * Sets the redirect for the PortalInformation.
     *
     * @param string $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Returns the redirect for the PortalInformation.
     *
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * Sets the segment for the PortalInformation.
     *
     * @param \Sulu\Component\Webspace\Segment $segment
     */
    public function setSegment($segment)
    {
        $this->segment = $segment;
    }

    /**
     * Returns the segment for the PortalInformation.
     *
     * @return \Sulu\Component\Webspace\Segment
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * Sets the match type of this PortalInformation.
     *
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the match type of this PortalInformation.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the URL of this Portalinformation.
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns the URL of this Portalinformation.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the analytics key of this Portalinformation.
     *
     * @param string $analyticsKey
     */
    public function setAnalyticsKey($analyticsKey)
    {
        $this->analyticsKey = $analyticsKey;
    }

    /**
     * Returns the analytics key of this Portalinformation.
     *
     * @return string
     */
    public function getAnalyticsKey()
    {
        return $this->analyticsKey;
    }

    /**
     * Returns the host including the domain for the PortalInformation.
     *
     * @return string
     */
    public function getHost()
    {
        return substr($this->url, 0, $this->getHostLength());
    }

    /**
     * Returns the prefix (the url without the host) for this PortalInformation.
     *
     * @return string
     */
    public function getPrefix()
    {
        return substr($this->url, $this->getHostLength());
    }

    /**
     * Sets the webspace for this PortalInformation.
     *
     * @param \Sulu\Component\Webspace\Webspace $webspace
     */
    public function setWebspace($webspace)
    {
        $this->webspace = $webspace;
    }

    /**
     * Returns the webspace for this PortalInformation.
     *
     * @return \Sulu\Component\Webspace\Webspace
     */
    public function getWebspace()
    {
        return $this->webspace;
    }

    /**
     * Calculate the length of the host part of the URL.
     *
     * @return int
     */
    private function getHostLength()
    {
        $hostLength = strpos($this->url, '/');
        $hostLength = ($hostLength === false) ? strlen($this->url) : $hostLength;

        return $hostLength;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray($depth = null)
    {
        $res = array();
        $res['type'] = $this->getType();
        $res['webspace'] = $this->getWebspace()->getKey();
        $res['url'] = $this->getUrl();

        $portal = $this->getPortal();

        if ($portal) {
            $res['portal'] = $portal->getKey();
        }

        $localization = $this->getLocalization();

        if ($localization) {
            $res['localization'] = $localization->toArray();
        }

        $res['redirect'] = $this->getRedirect();

        $segment = $this->getSegment();
        if ($segment) {
            $res['segment'] = $segment->getKey();
        }

        $analyticsKey = $this->getAnalyticsKey();
        if ($analyticsKey) {
            $res['analyticsKey'] = $analyticsKey;
        }

        return $res;
    }
}
