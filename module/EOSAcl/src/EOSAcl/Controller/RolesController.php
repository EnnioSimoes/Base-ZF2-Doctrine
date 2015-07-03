<?php

namespace EOSAcl\Controller;

/**
 * Description of RolesController
 *
 * @author ennio
 */
use EOSBase\Controller\CrudController;
use Zend\View\Model\ViewModel;


class RolesController extends CrudController
{
    public function __construct()
    {
        $this->entity = "EOSAcl\Entity\Role";
        $this->service = "EOSAcl\Service\Role";
        $this->form = "EOSAcl\Form\Role";
        $this->controller = "roles";
        $this->route = "eosacl-admin/default";
    }
    
    public function newAction()
    {
        //Chamando form como servico, pois ele tem uma dependencia
        $form = $this->getServiceLocator()->get('EOSAcl\Form\Role');
        $request = $this->getRequest();
        
        if ($request->isPost()){
            
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());
                
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }
        return new ViewModel(array('form'=>$form));
    }
    
    public function editAction()
    {
        $form = $this->getServiceLocator()->get('EOSAcl\Form\Role');
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id', 0));
        
        if($this->params()->fromRoute('id', 0)){
            $form->setData($entity->toArray());
        }
        
        if ($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }
        return new ViewModel(array('form'=>$form));
    }    
}
