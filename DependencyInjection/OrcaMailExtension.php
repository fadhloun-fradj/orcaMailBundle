<?php

namespace Orca\MailBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class OrcaMailExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);
        $container->setParameter('is_mail_enabled', $config['is_mail_enabled']);
        $container->setParameter('is_mail_destinataire_enabled', $config['is_mail_destinataire_enabled']);
        $container->setParameter('mail_destinataire', $config['mail_destinataire']);
        $container->setParameter('mail_expediteur', $config['mail_expediteur']);
        $container->setParameter('projet', $config['projet']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
