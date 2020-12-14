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
            $copy = $this->modifyRequestWithIp($request, $ip);

            $response = $this->trySendModifiedRequest($copy);
            if (null === $response) {
                continue;
            }

            return $response;
        }

        return parent::send($request);
    }

    private function modifyRequestWithIp(CurlRequest $request, string $ip): CurlRequest
    {
        $copy = $request;
        if (false === $copy->hasHeader('Host')) {
            $copy = $copy->withHeader('Host', $request->getUri()->getHost());
        }

        $copy = $copy->withUri($request->getUri()->withHost($ip));

        return $copy;
    }

    /**
     * @param CurlRequest $request
     *
     * @return CurlResponse|null Null, when we got connection error and should try to use the next resolved IP.
     */
    private function trySendModifiedRequest(CurlRequest $request): ?CurlResponse
    {
        try {
            return parent::send($request);
        } catch (\Http\Client\Curl\Exception\TimeoutException $e) {
            // We should skip error only when it is relates to TCP socket connection errors.
            // Timeout error is not safe to retry (timeout exception introduced in `code-tool/curl-client:5.4.0`)
            throw $e;
        } catch (ConnectException $e) {
            return null;
        }
    }
}
