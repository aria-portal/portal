<?php declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    private const CONFIG_EXISTS = '.{xml,yaml,yml}';

    use MicroKernelTrait;

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }

    /**
     * @param ContainerBuilder $container
     * @return void
     */
    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $configDir = $this->getProjectDir() . '/config';

        $container->addResource(new FileResource($configDir . '/bundles.php'));

        $loader->load($configDir . '/{packages}/*' . self::CONFIG_EXISTS, 'glob');
        $loader->load($configDir . '/{packages}/' . $this->environment . '/*' . self::CONFIG_EXISTS, 'glob');
        $loader->load($configDir . '/services/*' . self::CONFIG_EXISTS, 'glob');

        if (is_dir($configDir . '/services/' . $this->environment)) {
            $loader->load($configDir . '/services/' . $this->environment . '/*' . self::CONFIG_EXISTS, 'glob');
        }
    }

    protected function configureRoutes(RoutingConfigurator $routingConfigurator): void
    {
        $configDir = $this->getProjectDir() . '/config';

        $routingConfigurator->import($configDir . '/{routes}/' . $this->environment . '/*' . self::CONFIG_EXISTS, 'glob');
        $routingConfigurator->import($configDir . '/{routes}/*' . self::CONFIG_EXISTS, 'glob');
        $routingConfigurator->import($configDir . '/{routes}' . self::CONFIG_EXISTS, 'glob');
    }
}
