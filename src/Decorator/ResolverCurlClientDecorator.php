<?php
declare(strict_types=1);

namespace Http\Client\Curl\Decorator;

use Http\Client\Curl\CurlClientInterface;
use Http\Client\Curl\Exception\ConnectException;
use Http\Client\Curl\Request\CurlRequest;
use Http\Client\Curl\Resolver\ResolverInterface;
use Http\Client\Curl\Response\CurlResponse;

class ResolverCurlClientDecorator extends AbstractCurlClientDecorator
{
    private $resolver;

    public function __construct(CurlClientInterface $curlClient, ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        parent::__construct($curlClient);
    }

    public function send(CurlRequest $request): CurlResponse
    {
        foreach ($this->resolver->resolve($request->getUri()->getHost()) as $ip) {
            $copy = $request;
            if (false === $copy->hasHeader('Host')) {
                $copy = $copy->withHeader('Host', $request->getUri()->getHost());
            }
            $copy = $copy->withUri($request->getUri()->withHost($ip));
            try {
                return parent::send($copy);
            } catch (\Http\Client\Curl\Exception\TimeoutException $e) {
                throw $e;
            } catch (ConnectException $e) {
                continue;
            }
        }

        return parent::send($request);
    }
}
