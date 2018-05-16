<?php
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

    /**
     * @param CurlRequest $request
     *
     * @return CurlResponse
     */
    public function send(CurlRequest $request)
    {
        if (null === ($ip = $this->resolver->resolve($request->getUri()->getHost()))) {
            return parent::send($request);
        }
        $resovledRequest = $request->withUri($request->getUri()->withHost($ip));
        try {
            return parent::send($resovledRequest);
        } catch (ConnectException $e) {
            return parent::send($request);
        }
    }
}
