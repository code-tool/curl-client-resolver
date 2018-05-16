<?php
namespace Http\Client\Curl\Resolver;

class DummyResolver implements ResolverInterface
{
    /**
     * @param string $host
     *
     * @return null|string
     */
    public function resolve($host)
    {
        return null;
    }
}
