<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

class CompositeResolver implements ResolverInterface
{
    private $queue;

    public function __construct()
    {
        $this->queue = new \SplPriorityQueue();
    }

    /**
     * @param int               $priority
     * @param ResolverInterface $resolver
     *
     * @return CompositeResolver
     */
    public function add($priority, ResolverInterface $resolver)
    {
        $this->queue->insert($resolver, $priority);

        return $this;
    }

    /**
     * @param string $host
     *
     * @return array
     */
    public function resolve($host)
    {
        $queue = clone $this->queue;
        while (false === $queue->isEmpty()) {
            if ([] === ($ips = $queue->extract()->resolve($host))) {
                continue;
            }

            return $ips;
        }

        return [];
    }
}
