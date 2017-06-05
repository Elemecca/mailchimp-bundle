<?php

namespace Elemecca\MailchimpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elemecca_mailchimp');

        $rootNode
          ->children()
            ->scalarNode('key')
              ->isRequired()->cannotBeEmpty()
              ->info('Your Mailchimp API key')
            ->end()
          ->end();

        return $treeBuilder;
    }
}