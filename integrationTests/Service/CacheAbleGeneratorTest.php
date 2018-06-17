<?php declare(strict_types = 1);

namespace Searchmetrics\SeniorTest\integrationTests\Service;

use PHPUnit\Framework\TestCase;
use Searchmetrics\SeniorTest\Network\PhpUrlIdGenerator;
use Searchmetrics\SeniorTest\Service\FileSystemCache;
use Searchmetrics\SeniorTest\Service\CacheAbleGenerator;

class CacheAbleGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function idGenerationAndCacheGet()
    {
        $phpUrlIdGenerator = new PhpUrlIdGenerator();
        $fileSystemCache = new FileSystemCache();

        $cacheAbleGenerator = new CacheAbleGenerator($phpUrlIdGenerator, $fileSystemCache);

        $this->assertSame($cacheAbleGenerator->generate('https://google.de:80/hh'), $phpUrlIdGenerator->generate('https://google.de:80/hh'));
        $this->assertSame($fileSystemCache->get('https://google.de:80/hh'), $phpUrlIdGenerator->generate('https://google.de:80/hh'));
    }
}
