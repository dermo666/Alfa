<?php

namespace App\Application\Resource;

use Gedmo\Timestampable;

use Doctrine\Common\ClassLoader, 
    Doctrine\Common\Annotations\AnnotationReader, 
    Doctrine\ODM\MongoDB\DocumentManager, 
    Doctrine\MongoDB\Connection, 
    Doctrine\ODM\MongoDB\Configuration, 
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver, 
    Doctrine\Common\EventManager,
    Gedmo\Timestampable\TimestampableListener;

class DoctrineMongo extends \Zend\Application\Resource\AbstractResource
{

  /**
   * Configure and Instantiate Mongo Document Manager.
   * 
   * @return \Doctrine\ODM\MongoDB\DocumentManager
   */
  public function init()
  {
    $options = $this->getOptions() + array(
                                       'defaultDB'         => 'my_database', 
                                       'proxyDir'          => PROJECT_PATH . '/data/mongo/proxies', 
                                       'proxyNamespace'    => 'Application\Proxies', 
                                       'hydratorDir'       => PROJECT_PATH . '/data/mongo/hydrators', 
                                       'hydratorNamespace' => 'Application\Hydrators',
                                      );
    
    $config = new Configuration();
    $config->setProxyDir($options ['proxyDir']);
    $config->setProxyNamespace($options ['proxyNamespace']);
    $config->setHydratorDir($options ['hydratorDir']);
    $config->setHydratorNamespace($options ['hydratorNamespace']);
    $config->setDefaultDB($options ['defaultDB']);
    
    $reader = new AnnotationReader();
    $reader->setDefaultAnnotationNamespace('Doctrine\ODM\MongoDB\Mapping\\');
    
    $config->setMetadataDriverImpl(new AnnotationDriver($reader, $this->getDocumentPaths()));
    
    $evm = new EventManager();
    $evm->addEventSubscriber(new TimestampableListener());

    return DocumentManager::create(new Connection(), $config, $evm);
  }

  /**
   * Get Path to Documents.
   * 
   * TODO: This should be cached for production environment - see the DIC cache.
   * 
   * @return array
   */
  public function getDocumentPaths()
  {
    $paths = array();
    foreach(new \DirectoryIterator(PROJECT_PATH . '/library/Domain') as $package) {
      $path = $package->getPathname() . '/Entity';
      
      if((! $package->isDir() || $package->isDot()) || ! is_dir($path)) {
        continue;
      }
      
      $paths [] = $path;
    }
    
    if(! isset($paths)) {
      throw new \Exception("No documents found");
    }
    
    return $paths;
  }

}