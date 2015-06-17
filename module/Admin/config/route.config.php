<?php
return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/admin',
                    'defaults' => [
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'user' => [
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route'    => '/user',
                            'defaults' => [
                                'controller' => 'Admin\Controller\User',
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            'add' => [
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => [
                                    'route'    => '/add',
                                    'defaults' => [
                                        'controller' => 'Admin\Controller\User',
                                        'action'     => 'add',
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type'    => 'Zend\Mvc\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/edit/:id',
                                    'constraints' => [
                                        'id'    => '[0-9]*'
                                    ],
                                    'defaults' => [
                                        'controller' => 'Admin\Controller\User',
                                        'action'     => 'edit',
                                    ],
                                ],
                            ],
                            'delete' => [
                                'type'    => 'Zend\Mvc\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/delete/:id',
                                    'constraints' => [
                                        'id'    => '[0-9]*'
                                    ],
                                    'defaults' => [
                                        'controller' => 'Admin\Controller\User',
                                        'action'     => 'delete',
                                    ],
                                ],
                            ],
                        ]
                    ],
                ],
            ]
        ],
    ],
];