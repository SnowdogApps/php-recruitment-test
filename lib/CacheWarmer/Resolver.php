<?php
namespace Lib\CacheWarmer;

class Resolver implements ResolverInterface
{
    public function getIp($hostname)
    {
        return gethostbyname($hostname);
    }
}
