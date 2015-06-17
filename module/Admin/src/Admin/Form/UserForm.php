<?php

namespace Admin\Form;

use Application\Service\UserService;
use WebReattivoCore\Entity\User;
use WebReattivoCore\Utility\Roles;
use WebReattivoCore\Utility\UserStatus;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class UserForm extends Form implements InputFilterProviderInterface
{
    /** @var  UserService */
    private $userService;

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->setHydrator($options['hydrator']);
        $this->setObject(new User());

        $this->add([
            'name'       => 'id',
            'type'       => 'Zend\Form\Element\Hidden',
            'attributes' => [
                'id' => 'id'
            ]
        ]);

        $this->add([
            'name'       => 'name',
            'type'       => 'Zend\Form\Element\Text',
            'attributes' => [
                'id'       => 'name',
                'class'    => 'form-control',
                'required' => 'required',
            ]
        ]);

        $this->add([
            'name'       => 'surname',
            'type'       => 'Zend\Form\Element\Text',
            'attributes' => [
                'id'       => 'surname',
                'class'    => 'form-control',
                'required' => 'required',
            ]
        ]);

        $this->add([
            'name'       => 'status',
            'type'       => 'Zend\Form\Element\Select',
            'attributes' => [
                'id'       => 'status',
                'class'    => 'form-control',
                'required' => 'required',
            ],
            'options'    => [
                'value_options' => [
                    UserStatus::ACTIVE    => "Attivo",
                    UserStatus::PENDING   => "In Attesa",
                    UserStatus::SUSPENDED => "Sospeso",
                ]
            ]
        ]);

        $this->add([
            'name'       => 'role',
            'type'       => 'Zend\Form\Element\Select',
            'attributes' => [
                'id'       => 'role',
                'class'    => 'form-control',
                'required' => 'required',
            ],
            'options'    => [
                'value_options' => [
                    Roles::USER  => "Utente",
                    Roles::ADMIN => "Administrator"
                ]
            ]
        ]);

        $this->add([
            'name'       => 'email',
            'type'       => 'Zend\Form\Element\Email',
            'attributes' => [
                'id'       => 'email',
                'class'    => 'form-control',
                'required' => 'required'
            ]
        ]);

        $this->add([
            'name'       => 'email2',
            'type'       => 'Zend\Form\Element\Email',
            'attributes' => [
                'id'       => 'email2',
                'class'    => 'form-control',
                'required' => 'required'
            ]
        ]);

        $this->add([
            'name'       => 'password',
            'type'       => 'Zend\Form\Element\Password',
            'attributes' => [
                'id'       => 'password',
                'class'    => 'form-control',
            ]
        ]);

        $this->add([
            'name'       => 'password2',
            'type'       => 'Zend\Form\Element\Password',
            'attributes' => [
                'id'       => 'password',
                'class'    => 'form-control',
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'id'        => [
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim'
                    ]
                ]
            ],
            'name'      => [
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim'
                    ]
                ]
            ],
            'surname'   => [
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim'
                    ]
                ]
            ],
            'email'     => [
                'required'   => true,
                'validators' => [
                    [
                        'name'                   => 'EmailAddress',
                        'break_chain_on_failure' => true
                    ]
                ]
            ],
            'email2'    => [
                'required'   => true,
                'validators' => [
                    [
                        'name'                   => 'EmailAddress',
                        'break_chain_on_failure' => true
                    ],
                    [
                        'name'    => 'Identical',
                        'options' => [
                            'token' => 'email'
                        ]
                    ]
                ]
            ],
            'password'  => [
                'required'   => true,
                'filters'    => [
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 8
                        ]
                    ]
                ]
            ],
            'password2' => [
                'required'   => true,
                'filters'    => [
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name'                   => 'StringLength',
                        'options'                => [
                            'min' => 8
                        ],
                        'break_chain_on_failure' => true
                    ],
                    [
                        'name'    => 'Identical',
                        'options' => [
                            'token' => 'password'
                        ]
                    ]
                ]
            ],
            'status'    => [
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim'
                    ]
                ]
            ],
            'role'      => [
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StringTrim'
                    ]
                ]
            ]
        ];
    }
}