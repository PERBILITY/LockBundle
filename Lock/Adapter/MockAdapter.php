<?php

/*
 * This file is part of the PerbilityLockBundle package. 
 * 
 * (c) PERBILITY GmbH <http://www.perbility.de> 
 * 
 * For the full copyright and license information, please view the LICENSE 
 * file that was distributed with this source code.
 */
namespace Perbility\Bundle\LockBundle\Lock\Adapter;

class MockAdapter implements AdapterInterface
{
    protected $locks = [];
    
    public function __construct()
    {
        foreach (func_get_args() as $arg) {
            $this->acquire($arg, false);
        }
    }
    
    /*
     * (non-PHPdoc) @see \Perbility\Bundle\LockBundle\Lock\Adapter\AdapterInterface::acquire()
     */
    public function acquire($name, $blocking = true)
    {
        while ($blocking && isset($this->locks[$name])) {
            // @codeCoverageIgnoreStart
            usleep(10);   
        }
        // @codeCoverageIgnoreEnd
        
        // non-blocking, cannot be acquired
        if (isset($this->locks[$name])) {
            return false;
        }
        
        $this->locks[$name] = 1;
        return true;
    }
    
    /*
     * (non-PHPdoc) @see \Perbility\Bundle\LockBundle\Lock\Adapter\AdapterInterface::release()
     */
    public function release($name)
    {
        unset($this->locks[$name]);
    }
    
    /*
     * (non-PHPdoc) @see \Perbility\Bundle\LockBundle\Lock\Adapter\AdapterInterface::isLocked()
     */
    public function isLocked($name)
    {
        return isset($this->locks[$name]);
    }
} 