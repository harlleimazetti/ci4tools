<?php namespace Harlleimazetti\Ci4tools\Route;

use \Harlleimazetti\Ci4tools\Route\RouteTrait;

class RouteController extends \CodeIgniter\Controller {
  use RouteTrait { RouteTrait::init as private initRouteTrait; }

	function __construct()
	{
    $this->initRouteTrait();
	}
}

/* Fim do arquivo RouteController.php */
/* Local: /Harlleimazetti/Ci4tools/Route/RouteController.php */
