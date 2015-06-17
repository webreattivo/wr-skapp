<?php
namespace WebReattivoCore\Service;

use WebReattivoCore\Utility\ErrorException;
use Zend\Crypt\Password\Bcrypt;
use Zend\Http\PhpEnvironment\RemoteAddress;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * Class BaseService
 * @package WebReattivoCore\Service
 */
class BaseService implements ServiceLocatorAwareInterface
{
    /**
     * @var
     */
    public $entity;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param ServiceLocatorInterface $ServiceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $ServiceLocator)
    {
        $this->serviceLocator = $ServiceLocator;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->entity);
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->getEntityManager()->getConnection();
    }

    /**
     * @return DoctrineHydrator
     */
    public function getDoctrineHydrator()
    {
        return new DoctrineHydrator($this->getEntityManager());
    }

    /**
     * @return \AcMailer\Service\MailService
     */
    public function getEmailService()
    {
        return $this->getServiceLocator()->get('acmailer.mailservice.default');
    }

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthentication()
    {
        return $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        /** @var RemoteAddress $ip */
        $ip = new RemoteAddress();

        return $ip->getIpAddress();
    }

    public function getDataTime()
    {
        return new \DateTime();
    }

    /**
     * @param $password
     *
     * @return string
     */
    public function getPasswordEncrypted($password)
    {
        /** @var Bcrypt $bcrypt */
        $bcrypt = new Bcrypt();

        return $bcrypt->create($password);
    }

    /**
     * @param int $id
     *
     * @return null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function find($id = 0)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException(ErrorException::INVALID_ARGUMENT);
        }

        return $this->getEntityManager()->find($this->entity, $id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findBy(array $criteria = [])
    {
        return $this->getRepository()->findBy($criteria);
    }

    /**
     * @param array $criteria
     *
     * @return null|object
     */
    public function findOneBy(array $criteria = [])
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * @param $entity
     *
     * @return mixed
     */
    public function persist($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }
}