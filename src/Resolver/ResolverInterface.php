<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

interface ResolverInterface
{
    /**
     * @param string $host
     *
     * @return string[]
     */
    public function resolve(string $host): array;
}
