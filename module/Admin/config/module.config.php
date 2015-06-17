<?php

return [
    'service_manager' => [
        'factories' => [
            'Admin\Service\User' => 'Admin\Factory\Service\UserFactory',
            'Admin\Form\User'    => 'Admin\Factory\Form\UserFactory',
        ]
    ],
    'view_manager'    => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'asset_manager'   => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
];
