<?php

class ErrorController extends \Zend\Controller\Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) {
            case \Zend\Controller\Plugin\ErrorHandler::EXCEPTION_NO_ROUTE:
            case \Zend\Controller\Plugin\ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case \Zend\Controller\Plugin\ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->vars()->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->vars()->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if (($log = $this->getLog())) {
            $log->crit($this->view->vars()->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->vars()->exception = $errors->exception;
        }
        
        $this->view->vars()->request = $errors->request;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

