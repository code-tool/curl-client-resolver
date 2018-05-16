<?php
namespace Http\Client\Curl\Resolver;

class DummyResolver implements ResolverInterface
{
    /**
     * @param string $host
     *
     * @return array
     */
    public function resolve(string $host)
    {
        return [];
    }
}
