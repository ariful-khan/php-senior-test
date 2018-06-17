<?php declare(strict_types = 1);

namespace Searchmetrics\SeniorTest\Service;

interface Cache
{
    public function set(string $key, string $value) : void;

    public function get(string $key) : ?string;
}
