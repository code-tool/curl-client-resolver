<?php
declare(strict_types=1);

namespace Http\Client\Curl\Resolver;

class CompositeResolver implements ResolverInterface
{
    private $queue;

    public function __construct(\SplPriorityQueue $queue)
    {
        $this->queue = $queue;
    }

    public function add(int $priority, ResolverInterface $resolver): CompositeResolver
    {
        $this->queue->insert($resolver, $priority);

        return $this;
    }

    public function resolve(string $host): ?string
    {
        $queue = clone $this->queue;
        while (false === $queue->isEmpty()) {
            if (null === ($ip = $queue->extract()->resolve($host))) {
                continue;
            }

            return $ip;
        }

        return null;
    }
}
