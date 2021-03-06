<?php

namespace EOSAcl\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * Description of RoleRepository
 *
 * @author ennio
 */
class RoleRepository extends EntityRepository
{
    public function fetchParent()
    {
        $entities = $this->findAll();
        $array = array();
        
        foreach ($entities as $entity){
            //Populando um array com ex. $array[1] = Nome ...
            $array[$entity->getId()] = $entity->getNome();
        }
        return $array;
    }
}