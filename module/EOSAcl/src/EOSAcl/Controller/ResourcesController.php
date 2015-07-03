<?php

namespace EOSAcl\Controller;

/**
 * Description of RolesController
 *
 * @author ennio
 */
use EOSBase\Controller\CrudController;
use Zend\View\Model\ViewModel;


class ResourcesController extends CrudController
{
    public function __construct()
    {
        $this->entity = "EOSAcl\Entity\Resource";
        $this->service = "EOSAcl\Service\Resource";
        $this->form = "EOSAcl\Form\Resource";
        $this->controller = "resources";
        $this->route = "eosacl-admin/default";
    }  
}
