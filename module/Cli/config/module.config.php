<?php
return array(
    'cli_bootstrap_class' => 'Cli\Bootstrap',
    'console_options' => array(
        'cli|c'                 => 'Cli Controller',
        'messaging-consumer|mc' => 'MessagingConsumer Controller',
    ),
    'di' => array(
    	'instance' => array(
        	'alias' => array(
            	'cli'                => 'Cli\Controller\Cli',
            	'messaging-consumer' => 'Cli\Controller\MessagingConsumer',
            ),
            'Cli\Controller\MessagingConsumer' => array(
                'parameters' => array(
                    'amqpConnectionFactory' => 'App\Application\AmqpConnectionFactory',
                ),
            ),
        )
    ),
);
