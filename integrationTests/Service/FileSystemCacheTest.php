<?php

namespace Searchmetrics\SeniorTest\integrationTests\Service;

use PHPUnit\Framework\TestCase;
use Searchmetrics\SeniorTest\Service\FileSystemCache;

class FileSystemCacheTest extends TestCase
{
    /**
     * @test
     */
    public function setGet(): void
    {
        $fileSystemCache = new FileSystemCache();

        $fileSystemCache->set('testkey', 'testValue');
        $this->assertSame($fileSystemCache->get('testkey'), 'testValue');
    }

    /**
     * @test
     */
    public function getWithNonExistentKey(): void
    {
        $fileSystemCache = new FileSystemCache();

        $this->assertNotSame($fileSystemCache->get('testkey1'), 'testValue1');
    }
}
