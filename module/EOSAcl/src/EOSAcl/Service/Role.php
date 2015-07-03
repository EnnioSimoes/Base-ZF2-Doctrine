<?php

namespace EOSAcl\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use EOSBase\Service\AbstractService;
/**
 * Description of User
 *
 * @author ennio
 */
class Role extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em) 
    {
        parent::__construct($em);
        $this->entity = "EOSAcl\Entity\Role";
    }
    
    public function insert(array $data)
    {
        $entity = new $this->entity($data);
        if($data['parent']){
            $parent = $this->em->getReference($this->entity, $data['parent']);
            $entity->setParent($parent);
        }else{
            $entity->setParent(null);
        }
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function update(array $data)
    {
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);

        if($data['parent']){
            $parent = $this->em->getReference($this->entity, $data['parent']);
            $entity->setParent($parent);
        }else{
            $entity->setParent(null);
        }        
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
}
