<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'producer' => 'Messaging\Controller\ProducerController',
            ),
            'Messaging\Controller\ProducerController' => array(
                'parameters' => array(
                    'amqpConnectionFactory' => 'App\Application\AmqpConnectionFactory',
                ),
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'Messaging' => __DIR__ . '/../view',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
