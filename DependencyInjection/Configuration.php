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
              ->info('Your Mailchimp API key')
              ->isRequired()->cannotBeEmpty()
              ->validate()
              ->ifTrue(function ($apiKey) {
                return !preg_match('/^[0-9a-f]+-[a-z]+[0-9]+$/i', $apiKey);
              })
                ->thenInvalid('Invalid API key')
              ->end()
            ->end()
          ->end();

        return $treeBuilder;
    }
}