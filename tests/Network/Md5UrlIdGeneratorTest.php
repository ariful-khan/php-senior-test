<?php declare(strict_types = 1);

namespace Searchmetrics\SeniorTest\Tests\Network;

use PHPUnit\Framework\TestCase;
use Searchmetrics\SeniorTest\Network\Md5UrlIdGenerator;
use Searchmetrics\SeniorTest\Network\UrlIdGenerator;

final class Md5UrlIdGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function instantiation_works() : void
    {
        $generator = new Md5UrlIdGenerator();

        self::assertInstanceOf(Md5UrlIdGenerator::class, $generator);
        self::assertInstanceOf(UrlIdGenerator::class, $generator);
    }

    /**
     * @return mixed[]
     */
    public function provideGeneratorExpectations() : array
    {
        $providers = [];

        $file = \fopen(__DIR__ . '/../Resources/url_md5_ids.txt', 'r');

        if (false !== $file) {
            while (($line = \fgets($file)) !== false) {
                $providers[] = \explode("\t|\t", \trim($line));
            }

            \fclose($file);
        }

        return $providers;
    }

    /**
     * @test
     * @dataProvider provideGeneratorExpectations
     */
    public function generate_withValidUrl_returnsUrlId(string $url, string $expectedId) : void
    {
        $generatedId = (new Md5UrlIdGenerator())->generate($url);

        self::assertSame(
            $expectedId,
            $generatedId,
            \sprintf('Expected URL ID generator to return ID [%s], got [%s] instead.', $expectedId, $generatedId)
        );
    }
}
