<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

interface ResolverInterface
{
    public function resolve(string $host) : array;
}
