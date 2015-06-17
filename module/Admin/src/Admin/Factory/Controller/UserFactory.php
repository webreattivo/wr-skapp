<?php
namespace Admin\Factory\Controller;

use Admin\Controller\IndexController;

use Admin\Controller\UserController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserFactory
 * @package Admin\Factory\Controller
 */
class UserFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface|ControllerManager $serviceLocator
     *
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userService = $serviceLocator->getServiceLocator()->get('Admin\Service\User');
        $userForm = $serviceLocator->getServiceLocator()->get('Admin\Form\User');

        return new UserController($userService, $userForm);
    }
}