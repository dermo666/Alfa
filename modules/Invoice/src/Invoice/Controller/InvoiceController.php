<?php

namespace Invoice\Controller;

use Zend\Mvc\Controller\ActionController, 
    App\Application\MongoConnectionFactory;

class InvoiceController extends ActionController
{
	
  /**
   * Entity Manager Factory.
   * 
   * @var \App\Application\MongoConnectionFactory
   */	
  private $entityManagerFactory = NULL;
  
  public function indexAction()
  {
    $em = $this->entityManagerFactory->getEntityManager();
    
    return array();
  }
  
  /**
   * DI setter for Entity Manager Factory.
   * 
   * @param MongoConnectionFactory $entityManagerFactory Doctrine MongoDB Entity Manager Factory.
   * 
   * @return InvoiceController
   */
  public function setEntityManagerFactory(MongoConnectionFactory $entityManagerFactory)
  {
    $this->entityManagerFactory = $entityManagerFactory;
    return $this;
  }
}
