<?php
namespace Lib\CacheWarmer;

interface ResolverInterface
{
    public function getIp($hostname);
}
