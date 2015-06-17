<?php
return [
    'service_manager' => [
        'factories' => [
            'WebReattivoCore\Service\UserTokenService' => 'WebReattivoCore\Factory\Service\UserTokenFactory',
            'WebReattivoCore\Provider\Identity'        => 'WebReattivoCore\Factory\Provider\IdentityFactory'
        ]
    ]
];