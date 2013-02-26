<?php

namespace Thanatos\DigitalOceanBundle\DependencyInjection;

/*
 * This file is part of the Thanatos DigitalOcean bundle.
 *
 * (c) Kim Ausloos <kim@thanatos.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Kim Ausloos <kim@thanatos.be>
 */

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Validate the config
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('thanatos_digital_ocean');

        $rootNode
            ->children()
                ->scalarNode('apikey')->defaultValue('')->end()
                ->scalarNode('clientid')->defaultValue('')->end()
            ->end();

        return $treeBuilder;
    }
}
