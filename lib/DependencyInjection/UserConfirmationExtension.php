<?php
/**
 *  * Created by PhpStorm.
 * User: Dawid Bednarz( dawid@bednarz.pro )
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\DependencyInjection;

use DawBed\UserConfirmationBundle\Service\EntityService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class UserConfirmationExtension extends Extension implements PrependExtensionInterface
{
    const ALIAS = 'dawbed_user_confirmation_bundle';

    public function prepend(ContainerBuilder $container): void
    {
        $loader = $this->prepareLoader($container);
        $loader->load('packages/confirmation_bundle.yaml');
        $loader->load('packages/status_bundle.yaml');
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->setParameter('bundle_dir', dirname(__DIR__));
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = $this->prepareLoader($container);
        $loader->load('services.yaml');
        $this->prepareEntityService($config['entities'], $container);
    }

    public function getAlias(): string
    {
        return self::ALIAS;
    }

    private function prepareLoader(ContainerBuilder $containerBuilder): YamlFileLoader
    {
        return new YamlFileLoader($containerBuilder, new FileLocator(dirname(__DIR__) . '/Resources/config'));
    }

    private function prepareEntityService(array $entities, ContainerBuilder $container)
    {
        $container->setDefinition(EntityService::class, new Definition(EntityService::class, [[
                'UserActivateToken' => $entities['userActivateToken'],
            ]]
        ));
    }
}