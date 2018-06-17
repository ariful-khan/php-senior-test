<?php declare(strict_types=1);

use Searchmetrics\SeniorTest\Network\Md5UrlIdGenerator;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

use Searchmetrics\SeniorTest\Service\CacheAbleGenerator;
use Searchmetrics\SeniorTest\Service\FileSystemCache;

require __DIR__ . '/../vendor/autoload.php';

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle()
        );
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        // PHP equivalent of config/packages/framework.yaml
        $c->loadFromExtension('framework', array(
            'secret' => 'IlLWOtXNHlfwCNLoVLsr'
        ));
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        // kernel is a service that points to this class
        // optional 3rd argument is the route name
        $routes->add('/urlIds', 'kernel:urlIds');
    }

    public function urlIds(Request $request): JsonResponse
    {
        $cacheAbleGenerator = new CacheAbleGenerator(new Md5UrlIdGenerator(), new FileSystemCache());

        $urls = explode(',', $request->query->get('urls'));

        $urlIds = [];
        array_walk($urls, function ($url) use ($cacheAbleGenerator, &$urlIds) {
            $urlIds[$url] = $cacheAbleGenerator->generate($url);
        });

        return new JsonResponse(array(
            'urlIds' => $urlIds
        ));
    }
}

$kernel = new Kernel('prod', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
