<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

class DummyResolver implements ResolverInterface
{
    /**
     * @param string $host
     *
     * @return array
     */
    public function resolve($host)
    {
        return [];
    }
}
