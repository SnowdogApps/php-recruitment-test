<?php

namespace Snowdog\DevTest\Model;

class Varnish
{
    public $id;
    public $varnish_id;
    public $website_id;
    public function __construct()
    {
        $this->id = intval($this->id);
        $this->varnish_id = intval($this->varnish_id);
        $this->website_id = intval($this->website_id);
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return int
     */
    public function getVarnishId()
    {
        return $this->varnish_id;
    }
    /**
     * @return int
     */
    public function getWebsiteId()
    {
        return $this->website_id;
    }
}