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

use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Loads the bundle configuration
 */
class ThanatosDigitalOceanExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('digitalocean.apikey',     $config['apikey']);
        $container->setParameter('digitalocean.clientid',   $config['clientid']);
    }
}
