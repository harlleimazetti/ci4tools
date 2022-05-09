<?php namespace Harlleimazetti\Ci4tools\Crud;

use \Harlleimazetti\Ci4tools\Crud\CrudTrait;

class CrudController extends \CodeIgniter\Controller {
  use CrudTrait {
    CrudTrait::init as private initCrudTrait;
  }

	function __construct()
	{
    $this->initCrudTrait();
	}
}

/* Fim do arquivo CrudController.php */
/* Local: /Harlleimazetti/Ci4tools/Crud/CrudController.php */
