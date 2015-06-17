<?php
return [
    'bjyauthorize' => [
        'guards' => [
            'BjyAuthorize\Guard\Controller' => [
                ['controller' => 'Admin\Controller\Index', 'roles' => [
                    \WebReattivoCore\Utility\Roles::ADMIN,
                ]],
                ['controller' => 'Admin\Controller\User', 'roles' => [
                    \WebReattivoCore\Utility\Roles::ADMIN
                ]],
            ]
        ]
    ]
];