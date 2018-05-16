<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

class DummyResolver implements ResolverInterface
{
    public function resolve(string $host): ?string
    {
        return null;
    }
}
