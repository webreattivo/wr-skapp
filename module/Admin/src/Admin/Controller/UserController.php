<?php

namespace Admin\Controller;

use Admin\Form\UserForm;
use Admin\Service\UserService;
use WebReattivoCore\Entity\User;
use WebReattivoCore\Utility\MessageSuccess;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    const ROUTE_USER = 'admin/user';

    /** @var  UserService */
    private $userService;

    /** @var  UserForm */
    private $userForm;

    function __construct(UserService $userService, UserForm $userForm)
    {
        $this->userService = $userService;
        $this->userForm = $userForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->userService->findAll()
        ]);
    }

    public function addAction()
    {
        $form = $this->userForm;

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray();
            $form->setData($data);
            $form->getInputFilter()->get('id')->setRequired(false);

            if ($form->isValid()) {

                try {

                    $this->userService->saveUser($form->getData());
                    $this->flashMessenger()->addSuccessMessage(MessageSuccess::DEFALUT_MESSAGE);

                } catch (\Exception $e) {

                    $this->flashMessenger()->addErrorMessage($e->getMessage());

                }

                return $this->redirect()->toRoute(self::ROUTE_USER);
            }
        }

        return new ViewModel([
            'userForm' => $form
        ]);
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        /** @var User $user */
        $user = $this->userService->find($id);

        if (is_null($user)) {
            $this->getResponse()->setStatusCode(Response::STATUS_CODE_404);

            return false;
        }

        $form = $this->userForm;
        $userHydrator = $this->userService->getDoctrineHydrator()->extract($user);
        $userHydrator['email2'] = $user->getEmail();
        $form->setData($userHydrator);

        if ($this->getRequest()->isPost()) {

            $postData = $this->getRequest()->getPost()->toArray();
            $postData['id'] = $user->getId();
            $form->setData($postData);
            $form->getInputFilter()->get('password')->setRequired(false);
            $form->getInputFilter()->get('password2')->setRequired(false);

            if ($form->isValid()) {

                try {

                    $this->userService->saveUser($form->getData(), 'edit');

                    $this->flashMessenger()->addSuccessMessage(MessageSuccess::DEFALUT_MESSAGE);

                } catch (\Exception $e) {

                    $this->flashMessenger()->addErrorMessage($e->getMessage());

                }

                return $this->redirect()->toRoute(self::ROUTE_USER);
            }
        }

        return new ViewModel([
            'userForm' => $form,
            'user'     => $user
        ]);
    }
}