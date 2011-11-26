<?php

namespace Invoice\Controller;

use Zend\Mvc\Controller\ActionController, 
    App\Application\Resource\DoctrineMongo;

class InvoiceController extends ActionController
{
	
  /**
   * Entity Manager Factory.
   * 
   * @var \App\Application\Resource\DoctrineMongo
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
   * @param DoctrineMongo $entityManagerFactory Doctrine MongoDB Entity Manager Factory.
   * 
   * @return InvoiceController
   */
  public function setEntityManagerFactory(DoctrineMongo $entityManagerFactory)
  {
    $this->entityManagerFactory = $entityManagerFactory;
    return $this;
  }
}
