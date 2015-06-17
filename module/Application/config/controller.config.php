<?php
return [
    'controllers' => [
        'factories' => [
            'Application\Controller\Index'   => 'Application\Factory\Controller\IndexFactory',
            'Application\Controller\Login'   => 'Application\Factory\Controller\LoginFactory',
            'Application\Controller\User'    => 'Application\Factory\Controller\UserFactory',
            'Application\Controller\Profile' => 'Application\Factory\Controller\ProfileFactory'
        ]
    ],
];