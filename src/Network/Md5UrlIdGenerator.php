<?php declare(strict_types = 1);

namespace Searchmetrics\SeniorTest\Network;


final class Md5UrlIdGenerator extends AbstractUrlIdGenerator
{
    /**
     * @param string $url
     * @return string
     */
    protected function generateId(string $url) : string
    {
        return base_convert((substr(md5($url), 0, 16)), 16, 8);
    }
}
