<?php
namespace Http\Client\Curl\Resolver;

class CompositeResolver implements ResolverInterface
{
    private $queue;

    public function __construct(\SplPriorityQueue $queue)
    {
        $this->queue = $queue;
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
    public function resolve(string $host)
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
