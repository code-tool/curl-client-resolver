<?php
namespace Http\Client\Curl\Resolver;

interface ResolverInterface
{
    public function resolve(string $host) : array;
}
