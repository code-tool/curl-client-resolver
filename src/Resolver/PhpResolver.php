<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

class PhpResolver implements ResolverInterface
{
    /**
     * @param string $host
     *
     * @return array
     */
    public function resolve($host)
    {
        $resolved = gethostbyname($host);

        return ($resolved !== $host) ? [$resolved] : [];
    }
}
