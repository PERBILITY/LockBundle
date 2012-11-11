<?php

/*
 * This file is part of the PerbilityLockBundle package. 
 * 
 * (c) PERBILITY GmbH <http://www.perbility.de> For the
 * 
 * full copyright and license information, please view the LICENSE 
 * file that was distributed with this source code.
 */
namespace Perbility\Bundle\LockBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('perbility_lock')
        	->children()
	        	->scalarNode('namespace')->defaultValue("")->end()
        		->arrayNode('adapter')
		        	->children()
				        ->scalarNode('class')
				        	->beforeNormalization()
					        	->ifTrue(function($v) { return strpos($v, "\\") !== 0; })
					        	->then(function($v) { return "\\Perbility\\Bundle\\LockBundle\\Lock\\Adapter\\" . $v;})
					       	->end()
				        	->validate()
					        	->ifTrue(function($v) {return !class_exists($v);})
					        	->thenInvalid("No adapter found (%s)")
					       	->end()
				        ->end()
				        ->arrayNode('args')
				        	->prototype('variable')->end()
				        ->end()
				    ->end()
        		->end()
        	->end();
    
        return $treeBuilder;
    }
    
}