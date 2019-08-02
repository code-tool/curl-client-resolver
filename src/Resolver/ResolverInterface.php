<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

interface ResolverInterface
{
    /**
     * @param string $host
     *
     * @return array
     */
    public function resolve($host);
}
