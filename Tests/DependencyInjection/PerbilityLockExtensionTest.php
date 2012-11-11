<?php

/*
 * This file is part of the PerbilityLockBundle package.
 *
 * (c) PERBILITY GmbH <http://www.perbility.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perbility\Bundle\LockBundle\Tests\DependencyInjection;

use Perbility\Bundle\LockBundle\Lock\LockService;
use Perbility\Bundle\LockBundle\Lock\Adapter\MockAdapter;
use Perbility\Bundle\LockBundle\DependencyInjection\PerbilityLockExtension;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PerbilityLockExtensionTest extends PHPUnit_Framework_TestCase
{
    
    protected $extension;
    protected $container;
    
    public function setUp()
    {
        $this->extension = new PerbilityLockExtension();
        $this->container = new ContainerBuilder();
    }
    
    public function testAdapterCreationWithFullClassname()
    {
        $this->extension->load([
        	"perbility_lock" => [
                "adapter" => [
                	"class" => "\\Perbility\\Bundle\\LockBundle\\Lock\\Adapter\\MockAdapter"
               	]
    		]
		], $this->container);
        
        $this->assertTrue($this->container->get('perbility_lock.adapter') instanceof MockAdapter);
    }
    
    public function testAdapterCreationWithAdapterName()
    {
        $this->extension->load([
			"perbility_lock" => [
                "adapter" => [
            	    "class" => "MockAdapter"
                ]
            ]
        ], $this->container);
        
        $this->assertTrue($this->container->get('perbility_lock.adapter') instanceof MockAdapter);
    }
    
    public function testAdapterCreationWithAdapterOptions()
    {
        $this->extension->load([
			"perbility_lock" => [
                "adapter" => [
            	    "class" => "MockAdapter",
                	"args" => ["test1", "test2"]
                ]
            ]
	    ], $this->container);
        
        $adapter = $this->container->get('perbility_lock.adapter');
        $this->assertTrue($adapter instanceof MockAdapter);
        $this->assertTrue($adapter->isLocked("test1"));
        $this->assertTrue($adapter->isLocked("test2"));
        $this->assertFalse($adapter->isLocked("test3"));
    }
    
    public function testServiceCreation()
    {
        $this->extension->load([
			"perbility_lock" => [
                "namespace" => "__test",
                "adapter" => ["class" => "MockAdapter"]
        	]
    	], $this->container);
        
        $service = $this->container->get('perbility_lock.service');
        $this->assertTrue($service instanceof LockService);
        $this->assertEquals($this->container->getParameter('perbility_lock.namespace'), "__test");
        
        $this->assertStringStartsWith("__test", $service->getLock("foo")->getName());
    }
    
    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testAdapterCreationWithMissingClass()
    {
        $this->extension->load([
			"perbility_lock" => [
            	"adapter" => [
                	"class" => "NonExistingAdapter",
                ]
			]
		], $this->container);
    }
    
}