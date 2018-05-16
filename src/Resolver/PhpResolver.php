<?php
namespace Http\Client\Curl\Resolver;

class PhpResolver implements ResolverInterface
{
    /**
     * @param string $host
     *
     * @return null|string
     */
    public function resolve($host)
    {
        $resolved = gethostbyname($host);

        return ($resolved !== $host) ? $resolved : null;
    }
}
