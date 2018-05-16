<?php
namespace Http\Client\Curl\Resolver;

class PhpResolver implements ResolverInterface
{
    /**
     * @param string $host
     *
     * @return array
     */
    public function resolve($host): array
    {
        $resolved = gethostbyname($host);

        return ($resolved !== $host) ? [$resolved] : [];
    }
}
