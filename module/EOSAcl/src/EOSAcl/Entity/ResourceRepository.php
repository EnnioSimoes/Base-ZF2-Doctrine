<?php

namespace EOSAcl\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * Description of ResourceRepository
 *
 * @author ennio
 */
class ResourceRepository extends EntityRepository
{
    public function fetchPairs()
    {
        $entities = $this->findAll();
        $array = array();
        foreach($entities as $entity){
            $array[$entity->getId()] = $entity->getNome();
        }
        return $array;
    }
}
