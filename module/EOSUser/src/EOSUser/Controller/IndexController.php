<?php
namespace EOSUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use EOSUser\Form\User as FormUser;
/**
 * Description of indexController
 *
 * @author ennio
 */
class IndexController extends AbstractActionController
{
    public function registerAction() 
    {
        $form = new FormUser;
        $request = $this->getRequest();
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid()){
                $service = $this->getServiceLocator()->get('EOSUser\Service\User');
                if($service->insert($request->getPost()->toArray())){
                    $fm = $this->flashMessenger()
                            ->setNamespace('EOSUser')
                            ->addMessage('Usuário cadastrado com sucesso');
                }
                return $this->redirect()->toRoute('eosuser-register');
            }
        }
        
        $messages = $this->flashMessenger()
                            ->setNamespace('EOSUser')
                            ->getMessages();
        return new ViewModel(array('form'=>$form, 'messages' => $messages));
    }
    
    public function activateAction()
    {
        $activationKey = $this->params()->fromRoute('key');
        
        $userService = $this->getServiceLocator()->get('EOSUser\Service\User');
        $result = $userService->activate($activationKey);
        if($result)
            return new ViewModel(array('user'=>$result));
        else
            return new ViewModel();
    }
}
