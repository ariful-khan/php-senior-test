<?php declare(strict_types = 1);

namespace Searchmetrics\SeniorTest\Service;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Cache\Adapter\Filesystem\FilesystemCachePool;

final class FileSystemCache implements Cache
{
    private $pool;

    public function __construct()
    {
        $filesystemAdapter = new Local(__DIR__ . '/../../var/urlIdsCache');
        $filesystem = new Filesystem($filesystemAdapter);

        $this->pool = new FilesystemCachePool($filesystem);
    }

    public function set(string $key, string $value) : void
    {
        $item = $this->pool->getItem(md5($key));
        $item->set($value);
        $this->pool->save($item);
    }

    public function get(string $key) : ?string
    {
        return $this->pool->getItem(md5($key))->get();
    }
}
