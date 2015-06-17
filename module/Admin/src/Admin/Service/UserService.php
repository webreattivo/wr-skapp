<?php

namespace Admin\Service;

use WebReattivoCore\Entity\User;
use WebReattivoCore\Service\BaseService;

class UserService extends BaseService
{
    public $entity = 'WebReattivoCore\Entity\User';

    public function saveUser(User $user, $action = 'add', $sendEmail = false)
    {
        try {

            if ($action == 'add') {
                $user->setDateRegistration($this->getDataTime());
                $user->setIp($this->getIpAddress());
            }

            $user->setPassword($this->getPasswordEncrypted($user->getPassword()));
            $this->persist($user);

            if ($sendEmail) {
                //@TODO send email with data
            }

            return $user;

        } catch (\Exception $e) {

            throw $e;
        }
    }
}