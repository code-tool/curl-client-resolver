<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

class PhpResolver implements ResolverInterface
{
    public function resolve(string $host): array
    {
        $resolved = gethostbyname($host);

        return ($resolved !== $host) ? [$resolved] : [];
    }
}
