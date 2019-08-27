<?php

namespace Orca\MailBundle\DependencyInjection;

use Orca\MailBundle\Utils\Constants;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('orca_mail')
                                ->children()
                                ->scalarNode('mail_nbr')->defaultValue(Constants::MAIL_NBR_DEFAULT)->info("Nombre de mails par tâche")->end()
                                ->scalarNode('is_mail_enabled')->isRequired()->defaultValue(Constants::IS_MAIL_DESTINATAIRE_ENABLED_DEFAULT)->info("0 => Pour désactiver, 1 => Pour Activer l'envoie")->end()
                                ->scalarNode('is_mail_destinataire_enabled')->isRequired()->defaultValue(Constants::IS_MAIL_ENABLED_DEFAULT)->info("1 => Pour l'envvironement de DEV||TEST, 0 => Pour l'envvironement")->end()
                                ->scalarNode('mail_destinataire')->defaultValue(Constants::MAIL_ADMIN)->end()
                                ->scalarNode('mail_expediteur')->info("Si mail expéditeur est vide")->defaultValue(Constants::MAIL_ADMIN)->end()
                                ->scalarNode('projet')->info("Le nom du projet")->defaultValue(Constants::PROJET)->end()
                                ->end()
        ;

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
