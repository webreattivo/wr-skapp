<?php
return [
    'router' => [
        'routes' => [
            'home'   => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'registration' => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/registration',
                    'defaults' => [
                        'controller' => 'Application\Controller\User',
                        'action'     => 'index',
                    ],
                ],
            ],
            'verify'       => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'       => '/verify/:token/:id',
                    'constraints' => [
                        'token' => '[a-zA-Z0-9]*',
                        'id'    => '[0-9]*'
                    ],
                    'defaults'    => [
                        'controller' => 'Application\Controller\User',
                        'action'     => 'verify',
                    ]
                ],
            ],
            'lost-pwd'     => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/lost-password',
                    'defaults' => [
                        'controller' => 'Application\Controller\User',
                        'action'     => 'lost-pwd',
                    ]
                ],
            ],
            'reset-pwd'    => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'       => '/reset-password/:token/:id',
                    'constraints' => [
                        'token' => '[a-zA-Z0-9]*',
                        'id'    => '[0-9]*'
                    ],
                    'defaults'    => [
                        'controller' => 'Application\Controller\User',
                        'action'     => 'reset-pwd',
                    ]
                ],
            ],
            'login'  => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => 'Application\Controller\User',
                        'action'     => 'login'
                    ]
                ]
            ],
            'logout' => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => 'Application\Controller\User',
                        'action'     => 'logout'
                    ]
                ]
            ],
            'profile'   => [
                'type'          => 'Zend\Mvc\Router\Http\Literal',
                'options'       => [
                    'route'    => '/profile',
                    'defaults' => [
                        'controller' => 'Application\Controller\Profile',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [

                ],
            ],
        ],
    ],
];