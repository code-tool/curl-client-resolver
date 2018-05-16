<?php
namespace Http\Client\Curl\Resolver;

interface ResolverInterface
{
    /**
     * @param string $host
     *
     * @return string|null
     */
    public function resolve($host);
}
