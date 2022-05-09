<?php namespace Harlleimazetti\Ci4tools\Crud;

use \Harlleimazetti\Ci4tools\Crud\CrudTrait;

class Crud extends \CodeIgniter\Controller {
  use CrudTrait { CrudTrait::init as private initCrudTrait; }

	function __construct()
	{
    $this->initCrudTrait();
	}
}

/* Fim do arquivo Crud.php */
/* Local: /Harlleimazetti/Ci4tools/Crud/Crud.php */
