<?php

/*
 * This file is part of the PerbilityLockBundle package.
 *
 * (c) PERBILITY GmbH <http://www.perbility.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perbility\Bundle\LockBundle\Lock;

use Perbility\Bundle\LockBundle\Lock\Adapter\AdapterInterface;

class LockService 
{
    
    protected $adapter;
    protected $namespace;
    
    public function __construct(AdapterInterface $adapter, $namespace="")
    {
        $this->adapter = $adapter;
        $this->namespace = $namespace;
    }
    
    public function getLock($name, $acquire = true)
    {
        $name = $this->namespace . $name;
        $lock = new Lock($name, $this->adapter);
        
        if ($acquire) {
            $lock->acquire(true);
        }
        
        return $lock;
    }
    
    public function getNamespace($name)
    {
        return new LockService($this->adapter, $this->namespace . $name);
    }
}
