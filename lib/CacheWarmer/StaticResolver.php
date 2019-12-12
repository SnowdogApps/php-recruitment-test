<?php
namespace Lib\CacheWarmer;

class StaticResolver implements ResolverInterface
{
    private $ip;

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getIp($hostname)
    {
        return $this->ip;
    }
}