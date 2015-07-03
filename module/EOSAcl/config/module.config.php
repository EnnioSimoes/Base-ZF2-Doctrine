<?php

namespace EOSAcl;

return array(
    'router' => array(
        'routes' => array(
            'eosacl-admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/acl',
                    'defaults' => array(
                        '__NAMESPACE__' => 'EOSAcl\Controller',
                        'controller' => 'Roles',
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
                                '__NAMESPACE__' => 'EOSAcl\Controller',
                                'controller' => 'roles'
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
                                '__NAMESPACE__' => 'EOSAcl\Controller',
                                'controller' => 'roles'
                            )
                        )
                    ),
                )
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'EOSAcl\Controller\Roles' => 'EOSAcl\Controller\RolesController',
            'EOSAcl\Controller\Resources' => 'EOSAcl\Controller\ResourcesController',
            'EOSAcl\Controller\Privileges' => 'EOSAcl\Controller\PrivilegesController'
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
            'EOSAcl_fixture' => __DIR__ . '/../src/EOSAcl/Fixture/'//TALVEZ SEJA PRECISO REMOVER A BARRA FINAL
        )        
    ),
//    'view_helpers' => array(
//        'invokables'=> array(
//            'UserIdentity' => new \EOSUser\View\Helper\UserIdentity()
//        )
//    ),      
);
