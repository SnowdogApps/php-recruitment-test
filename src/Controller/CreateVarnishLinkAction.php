<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishWebsiteLinkManager;
use Snowdog\DevTest\Model\VarnishManager;
use Snowdog\DevTest\Model\WebsiteManager;

class CreateVarnishLinkAction
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var VarnishManager
     */
    private $varnishManager;
    /**
     * @var WebsiteManager
     */
    private $websiteManager;
    /**
     * @var VarnishWebsiteLinkManager
     */
    private $varnishWebsiteLinkManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager, WebsiteManager $websiteManager, VarnishWebsiteLinkManager $varnishWebsiteLinkManager)
    {
        $this->userManager      = $userManager;
        $this->varnishManager   = $varnishManager;
        $this->websiteManager   = $websiteManager;
        $this->varnishWebsiteLinkManager = $varnishWebsiteLinkManager;
    }

    public function execute()
    {
        $response = ["status" => false, "message" => "Oops, something went wrong."];

        $status     = $_POST['status'];
        $varnishId  = $_POST['varnish_id'];
        $websiteId  = $_POST['website_id'];

        $varnish = $this->varnishManager->getVarnishById($varnishId);
        $wbsite = $this->websiteManager->getById($websiteId);
        if ($status) {
            if ($this->varnishWebsiteLinkManager->create($varnish->getId(), $wbsite->getWebsiteId())) {
                $response['status'] = true;
                $response['message'] = $wbsite->getHostname().' linked to '.$varnish->getIP().' server.';
            }
        } else {
            if ($this->varnishWebsiteLinkManager->delete($varnish->getId(), $wbsite->getWebsiteId())) {
                $response['status'] = true;
                $response['message'] = $wbsite->getHostname().' unlinked from '.$varnish->getIP().' server.';
            }
        }
        echo json_encode($response);
    }
}