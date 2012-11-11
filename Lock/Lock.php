<?php

/*
 * This file is part of the PerbilityDistributedLockBundle package.
 *
 * (c) PERBILITY GmbH <http://www.perbility.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perbility\Bundle\LockBundle\Lock;

use Perbility\Bundle\LockBundle\Lock\Adapter\AdapterInterface;
use InvalidArgumentException;

class Lock
{
    
    protected $name;
    protected $adapter;
    
    public function __construct($name, AdapterInterface $adapter)
    {
        $this->setName($name);
        $this->adapter = $adapter;
    }
    
    public function acquire($blocking = true)
    {
        return $this->adapter->acquire($this->name, $blocking);
    }
    
    public function release()
    {
        $this->adapter->release($this->name);
    }
    
    public function isLocked() 
    {
        return $this->adapter->isLocked($this->name);
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    protected function setName($name)
    {
        if (!is_scalar($name) && (!is_object($name) || !method_exists($name, "__toString"))) {
            throw new InvalidArgumentException("name can be only a scalar or an object with __toString");
        }
        $name = trim((string) $name);
        
        if (0 == strlen($name)) {
            throw new InvalidArgumentException("name has to be a string with a length > 0");
        }
        
        $this->name = $name;
    }
    
}