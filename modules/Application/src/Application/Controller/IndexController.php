<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
    	echo 'index';
        return array();
    }
    
    public function testAction()
    {
    	echo 'test';
        return array();
    }    
}
