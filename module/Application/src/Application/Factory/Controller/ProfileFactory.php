<?php
namespace Application\Factory\Controller;


use Application\Controller\ProfileController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ProfileFactory
 * @package Application\Factory\Controller
 */
class ProfileFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ProfileController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ProfileController();
    }
}