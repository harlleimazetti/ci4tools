<?php namespace Harlleimazetti\Ci4tools\Route;

use \Harlleimazetti\Ci4tools\Route\RouteTrait;

class Route {
  use RouteTrait {
    RouteTrait::init as private initRouteTrait;
  }

	function __construct()
	{
    $this->initRouteTrait();
	}
}

/* Fim do arquivo Route.php */
/* Local: /Harlleimazetti/Ci4tools/Route/Route.php */
