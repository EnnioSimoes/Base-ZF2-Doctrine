<?php

return array(
    'router' => array(
        'routes' => array(
            'eosuser-rest' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/api/user[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'EOSUserRest\Controller\UserRest'
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'EOSUserRest\Controller\UserRest' => 'EOSUserRest\Controller\UserRestController'
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy'
        )
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__.'_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__.'/../src/'.__NAMESPACE__.'/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__.'\Entity' => 'EOSUser' . '_driver'
                )
            )
        ),
        // Nova maneira de usardatafixture.
        'fixture' => array(
            'EOSUserRest_fixture' => __DIR__ . '/../src/EOSUserRest/Fixture/'//TALVEZ SEJA PRECISO REMOVER A BARRA FINAL
        )        
    ),
);
