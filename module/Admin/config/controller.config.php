<?php
return [
    'controllers' => [
        'factories' => [
            'Admin\Controller\Index' => 'Admin\Factory\Controller\IndexFactory',
            'Admin\Controller\User'  => 'Admin\Factory\Controller\UserFactory'
        ]
    ],
];