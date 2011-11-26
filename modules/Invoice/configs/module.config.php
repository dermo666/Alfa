<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'invoice' => 'Invoice\Controller\InvoiceController',
            ),
            'Invoice\Controller\InvoiceController' => array(
                'parameters' => array(
                    'entityManagerFactory' => 'App\Application\MongoConnectionFactory',
                ),
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'Invoice' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
