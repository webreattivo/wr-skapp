<?php
namespace Admin\Factory\Service;

use Admin\Service\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserFactory
 * @package Admin\Factory\Service
 */
class UserFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return UserService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UserService();
    }
}