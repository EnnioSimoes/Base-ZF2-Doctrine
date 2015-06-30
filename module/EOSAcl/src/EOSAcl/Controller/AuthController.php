<?php

namespace EOSUser\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use EOSUser\Form\Login as LoginForm;


class AuthController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new LoginForm;
        $error = FALSE;
        $request = $this->getRequest();
        if($request->isPost()){
            $form ->setData($request->getPost());
            if ($form->isValid()){
                $data = $request->getPost()->toArray();
                $sessionStorage = new SessionStorage("EOSUser");//Storage para guardar sessão de autenticação
                $auth = new AuthenticationService;
                $auth->setStorage($sessionStorage);//define sessionStorage para Auth
                $authAdapter = $this->getServiceLocator()->get('EOSUser\Auth\Adapter');
                $authAdapter->setUsername($data['email']);
                $authAdapter->setPassword($data['password']);
                $result = $auth->authenticate($authAdapter);
                if($result->isValid()){
                    $user = $auth->getIdentity();
                    $user = $user['user'];
                    $sessionStorage->write($user,null);
//                    $sessionStorage->write($auth->getIdentity()['user'], NULL);
                    return $this->redirect()->toRoute('eosuser-admin/default', array('controller'=>'users'));   
                } else {
                    $error = TRUE;
                }
            }
        }
        return new ViewModel(array('form'=>$form, 'error'=>$error));
    }
    
    public function logoutAction()
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("EOSUser"));
        $auth->clearIdentity();
        
        return $this->redirect()->toRoute('eosuser-auth');
    }
    
    
}
