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
     * @return null|string
     */
    public function resolve($host)
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
