<?php declare(strict_types = 1);

namespace Searchmetrics\SeniorTest\Service;

use Searchmetrics\SeniorTest\Network\UrlIdGenerator;

final class CacheAbleGenerator
{
    private $generator;
    private $cache;

    /**
     * @param UrlIdGenerator $generator
     * @param Cache $cache
     */
    public function __construct(UrlIdGenerator $generator, Cache $cache)
    {
        $this->generator = $generator;
        $this->cache = $cache;
    }

    /**
     * @param string $url
     * @return string
     */
    public function generate(string $url) : string
    {
        $id = $this->cache->get($url);
        if (!$id) {
            $id = $this->generator->generate($url);
            $this->cache->set($url, $id);
        }

        return $id;
    }
}
