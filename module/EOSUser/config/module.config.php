<?php

namespace EOSUser;

return array(
    'router' => array(
        'routes' => array(
            'eosuser-register' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/register',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EOSUser\Controller',
                        'controller' => 'Index',
                        'action' => 'register',
                    )
                )
            ),
            'eosuser-activate' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register/activate[/:key]',
                    'defaults' => array(
                        'controller' => 'EOSUser\Controller\Index',
                        'action' => 'activate',
                    )
                )
            ),
            'eosuser-auth' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EOSUser\Controller',
                        'controller' => 'Auth',
                        'action' => 'index'
                    )
                )
            ),
            'eosuser-logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EOSUser\Controller',
                        'controller' => 'Auth',
                        'action' => 'logout'
                    )
                )
            ),
            'eosuser-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EOSUser\Controller',
                        'controller' => 'Users',
                        'action' => 'index',
                    )
                ),
                'may_terminate' => TRUE,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'EOSUser\Controller',
                                'controller' => 'users'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'EOSUser\Controller',
                                'controller' => 'users'
                            )
                        )
                    ),
                )
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'EOSUser\Controller\Index' => 'EOSUser\Controller\IndexController',
            'EOSUser\Controller\Users' => 'EOSUser\Controller\UsersController',
            'EOSUser\Controller\Auth' => 'EOSUser\Controller\AuthController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
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
                    __NAMESPACE__.'\Entity' => __NAMESPACE__.'_driver'
                )
            )
        ),
        // Nova maneira de usardatafixture.
        'fixture' => array(
            'EOSUser_fixture' => __DIR__ . '/../src/EOSUser/Fixture/'//TALVEZ SEJA PRECISO REMOVER A BARRA FINAL
        )        
    ),
//    'view_helpers' => array(
//        'invokables'=> array(
//            'UserIdentity' => new \EOSUser\View\Helper\UserIdentity()
//        )
//    ),      
);
