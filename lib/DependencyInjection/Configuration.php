<?php
/**
 *  * Created by PhpStorm.
 * User: Dawid Bednarz( dawid@bednarz.pro )
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\DependencyInjection;

use DawBed\PHPUserActivateToken\UserActivateToken;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(UserConfirmationExtension::ALIAS);

        $entities = $rootNode
            ->children()
            ->arrayNode('entities')
            ->isRequired()
            ->children();

        $this->userActivateTokenEntity($entities);

        $entities
            ->end()
            ->end();

        return $treeBuilder;
    }

    private function userActivateTokenEntity(NodeBuilder $entities): void
    {
        $entities
            ->scalarNode('userActivateToken')
            ->cannotBeEmpty()
            ->isRequired()
            ->validate()
            ->ifTrue(function ($v) {
                return !class_exists($v);
            })
            ->thenInvalid('UserActivateToken entity not exists')
            ->ifTrue(function ($v) {
                return !is_subclass_of($v, UserActivateToken::class);
            })
            ->thenInvalid('UserActivateToken must be subclass of ' . UserActivateToken::class);
    }

}