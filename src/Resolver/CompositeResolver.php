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

    public function add(int $priority, ResolverInterface $resolver): CompositeResolver
    {
        $this->queue->insert($resolver, $priority);

        return $this;
    }

    public function resolve(string $host): array
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
