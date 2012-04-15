<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Cache\StorageFactory,
    Zend\Cache\Storage\Adapter\Memcached,
    Zend\Cache\Storage\Adapter\MemcachedOptions;

class CachingController extends ActionController
{
  /**
   * Cache Storage Adapter.
   * 
   * @var   Memcached
   */
  private $cache = NULL;
  
	public function indexAction()
	{
		if ($this->cache->hasItem('tomas')) {
		  $result = 'Cannot add - key is being used.';
		} else {
		  $this->cache->addItem('tomas', 'dermisek');
		  $result = 'Data stored.';
		}
		 
		return array('result' => $result);
	}

	public function removeAction()
	{
	  if ($this->cache->hasItem('tomas')) {
	    $this->cache->removeItem('tomas');
	    $result = 'Data removed.';
	  } else {
	    $result = 'Cannot remove, key is empty.';
	  }
	  
	  return array('result' => $result);
	}
	
	public function setCacheStorage(Memcached $cache)
	{
	  $this->cache = $cache;
	}
}
