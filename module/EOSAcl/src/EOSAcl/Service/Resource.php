<?php

namespace EOSAcl\Service;

use Doctrine\ORM\EntityManager;
use EOSBase\Service\AbstractService;
/**
 * Description of User
 *
 * @author ennio
 */
class Resource extends AbstractService
{
    public function __construct(\Doctrine\ORM\EntityManager $em) 
    {
        parent::__construct($em);
        $this->entity = "EOSAcl\Entity\Resource";
    }
}
