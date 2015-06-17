<?php

namespace Application\Controller;

use Application\Form\LoginForm;
use Application\Form\LostPasswordForm;
use Application\Form\RegistrationForm;
use Application\Form\ResetPasswordForm;
use Application\Service\UserService;
use WebReattivoCore\Entity\User;
use WebReattivoCore\Utility\MessageError;
use WebReattivoCore\Utility\MessageSuccess;
use WebReattivoCore\Utility\Roles;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    const ROUTE_REGISTER = 'registration';
    const ROUTE_LOST_PWD = 'lost-pwd';
    const ROUTE_ADMIN = 'admin';
    const ROUTE_PROFILE = 'profile';
    const ROUTE_LOGIN = 'login';
    const ROUTE_LOGOUT = 'logout';
    const ROUTE_HOME = 'home';

    /** @var  UserService */
    private $userService;

    /** @var RegistrationForm */
    private $registrationForm;

    /** @var  LostPasswordForm */
    private $lostPasswordForm;

    /** @var  ResetPasswordForm */
    private $resetPasswordForm;

    /**
     * @var \Application\Form\LoginForm
     */
    protected $loginForm;

    function __construct(
        UserService $userService,
        RegistrationForm $registrationForm,
        LostPasswordForm $lostPasswordForm,
        ResetPasswordForm $resetPasswordForm,
        LoginForm $loginForm
    ) {
        $this->userService = $userService;
        $this->registrationForm = $registrationForm;
        $this->lostPasswordForm = $lostPasswordForm;
        $this->resetPasswordForm = $resetPasswordForm;
        $this->loginForm = $loginForm;
    }

    public function indexAction()
    {
        $form = $this->registrationForm;

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray();
            $form->setData($data);

            if ($form->isValid()) {

                try {

                    /** @var User $user */
                    $user = $form->getData();
                    $this->userService->registration($user);
                    $this->flashMessenger()->addSuccessMessage(MessageSuccess::DEFALUT_MESSAGE);

                } catch (\Exception $e) {

                    $this->flashMessenger()->addErrorMessage($e->getMessage());

                }

                return $this->redirect()->toRoute(self::ROUTE_REGISTER);
            }
        }

        return new ViewModel([
            'registrationForm' => $form
        ]);
    }

    public function verifyAction()
    {
        $token = $this->params()->fromRoute('token', '');
        $id = (int)$this->params()->fromRoute('id', 0);
        $statusToken = true;
        $message = MessageSuccess::ACCOUNT_ACTIVE;

        $verifyToken = $this->userService->verify($token, $id);

        if (is_null($verifyToken)) {
            $message = MessageError::TOKEN_NOT_VALID;
            $statusToken = false;
        }

        if ($statusToken === true) {
            $this->userService->confirm($verifyToken);
        }

        return new ViewModel([
            'message'     => $message,
            'statusToken' => $statusToken
        ]);
    }

    public function lostPwdAction()
    {
        $form = $this->lostPasswordForm;

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray();
            $form->setData($data);

            if ($form->isValid()) {

                try {

                    $formData = $form->getData();

                    /** @var User $user */
                    $user = $this->userService->findOneBy(['email' => $formData['email']]);

                    if (is_null($user)) {
                        $this->flashMessenger()->addSuccessMessage(MessageSuccess::LOSTPWD_CONFIRM);

                        return $this->redirect()->toRoute(self::ROUTE_LOST_PWD);
                    }

                    $this->userService->lostPwd($user);
                    $this->flashMessenger()->addSuccessMessage(MessageSuccess::LOSTPWD_CONFIRM);

                } catch (\Exception $e) {

                    $this->flashMessenger()->addErrorMessage($e->getMessage());

                }

                return $this->redirect()->toRoute(self::ROUTE_LOST_PWD);
            }
        }

        return new ViewModel([
            'lostPasswordForm' => $form
        ]);
    }

    public function resetPwdAction()
    {
        $token = $this->params()->fromRoute('token', '');
        $id = (int)$this->params()->fromRoute('id', 0);
        $statusToken = true;
        $message = MessageSuccess::RESETPWD_CONFIRM;

        $verifyToken = $this->userService->verifyTokenLostPwd($token, $id);

        if (is_null($verifyToken)) {
            $message = MessageError::TOKEN_NOT_VALID;
            $statusToken = false;
        }

        $form = $this->resetPasswordForm;

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray();
            $data['id'] = $verifyToken->getUser()->getId();
            $form->setData($data);

            if ($form->isValid()) {

                try {

                    $this->userService->resetPwd($form->getData(), $verifyToken);
                    $this->flashMessenger()->addSuccessMessage($message);

                } catch (\Exception $e) {

                    $this->flashMessenger()->addErrorMessage($e->getMessage());

                }

                return $this->redirect()->toRoute(self::ROUTE_LOST_PWD);
            }
        }

        return new ViewModel([
            'message'      => $message,
            'statusToken'  => $statusToken,
            'resetPwdFrom' => $form
        ]);
    }

    public function loginAction()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        $form = $this->loginForm;
        if ($request->isPost()) {
            $form->setData($request->getPost()->toArray());
            if ($form->isValid()) {
                $data = $form->getData();

                /** @var User $auth */
                $auth = $this->userService->login($data['email'], $data['password']);
                if (is_object($auth)) {

                    if ($auth->getRole() == Roles::ADMIN) {
                        return $this->redirect()->toRoute(self::ROUTE_ADMIN);
                    } else {
                        return $this->redirect()->toRoute(self::ROUTE_PROFILE);
                    }
                }

                $this->flashMessenger()->addErrorMessage(MessageError::LOGIN_INVALID);

                return $this->redirect()->toRoute(self::ROUTE_LOGIN);
            }
        }

        return new ViewModel([
            'htmlForm' => $form
        ]);
    }

    public function logoutAction()
    {
        $this->userService->logout();

        return $this->redirect()->toRoute(self::ROUTE_HOME);
    }
}