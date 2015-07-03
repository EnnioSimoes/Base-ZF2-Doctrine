<?php

namespace EOSAcl\Service;

use Doctrine\ORM\EntityManager;
use EOSBase\Service\AbstractService;
/**
 * Description of User
 *
 * @author ennio
 */
class Privilege extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em) 
    {
        parent::__construct($em);
        $this->entity = "EOSAcl\Entity\Privilege";
    }
    
    public function insert(array $data)
    {
        $entity = new $this->entity($data);
        
        $role = $this->em->getReference("EOSAcl\Entity\Role",$data['role']);
        
        $entity->setRole($role); //Injetando Entidade carregada
        
        $resource = $this->em->getReference("EOSAcl\Entity\Resource", $data['resource']);
        $entity->setResource($resource); //Injetando Entidade carregada
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function update(array $data)
    {
        $entity = $this->em->getReference($this->entity, $data['id']);
        //(new Hydrator\ClassMethods())->hydrate($data, $entity);
        (new \Zend\Stdlib\Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $role = $this->em->getReference("EOSAcl\Entity\Role", $data['role']);
        $entity->setRole($role); //Injetando Entidade carregada
        
        $resource = $this->em->getReference("EOSAcl\Entity\Resource", $data['resource']);
        $entity->setResource($resource); //Injetando Entidade carregada        
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }    
}
