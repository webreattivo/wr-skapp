<?php
namespace Application\Factory\Controller;

use Application\Controller\IndexController;

use Application\Controller\UserController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserFactory
 * @package Application\Factory\Controller
 */
class UserFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface|ControllerManager $serviceLocator
     *
     * @return UserController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userService = $serviceLocator->getServiceLocator()->get('userService');
        $registrationForm = $serviceLocator->getServiceLocator()->get('registrationForm');
        $lostPasswordForm = $serviceLocator->getServiceLocator()->get('lostPasswordForm');
        $resetPasswordForm = $serviceLocator->getServiceLocator()->get('resetPasswordForm');
        $LoginForm = $serviceLocator->getServiceLocator()->get('LoginForm');

        return new UserController(
            $userService,
            $registrationForm,
            $lostPasswordForm,
            $resetPasswordForm,
            $LoginForm
        );
    }
}