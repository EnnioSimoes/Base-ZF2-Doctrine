<?php

namespace EOSUserRest\Controller;

/**
 * Description of UserRestController
 *
 * @author ennio
 */
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class UserRestController extends AbstractRestfulController
{
    public function getList()
    {
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $repo = $em->getRepository("EOSUser\Entity\User");
        
        $data = $repo->findArray();
        
        return new JsonModel(array('data' => $data));
    }
    
    public function get($id)
    {
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $repo = $em->getRepository("EOSUser\Entity\User");
        
        $data = $repo->find($id)->toArray();
        
        return new JsonModel(array('data' => $data));        
    }
    
    public function create($data)
    {
        $userService = $this->getServiceLocator()->get("EOSUser\Service\User");
        
        if($data){
            $user = $userService->insert($data);
            if($user){
                return new JsonModel(array('data' => array('id' => $user->getId(), 'success' => TRUE)));
            }else{
                return new JsonModel(array('data' => array('success' => 'Não foi inserido')));
            }
        }  else {
            return new JsonModel(array('data' => array('success' => 'Nenhum valor recebido')));
        }
    }
    
    public function update($id, $data)
    {
        $data['id'] = $id;
        $userService = $this->getServiceLocator()->get("EOSUser\Service\User");
        
        if($data){
            $user = $userService->update($data);
            if($user){
                return new JsonModel(array('data' => array('id' => $user->getId(), 'success' => TRUE)));
            }else{
                return new JsonModel(array('data' => array('success' => 'Não foi inserido')));
            }
        }  else {
            return new JsonModel(array('data' => array('success' => 'Nenhum valor recebido')));
        }
    }
    
    public function delete($id)
    {
        $userService = $this->getServiceLocator()->get("EOSUser\Service\User");
        $res = $userService->delete($id);
        
        if($res){
            return new JsonModel(array('data' => array('success' => TRUE)));
        }else{
            return new JsonModel(array('data' => array('success' => 'Não foi deletado')));
        }
    }
}
