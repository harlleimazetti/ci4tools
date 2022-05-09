<?php namespace Harlleimazetti\Ci4tools\Route;

use \Harlleimazetti\Ci4tools\Route\RouteTrait;

class Route extends \CodeIgniter\Controller {
  use RouteTrait;

	function __construct()
	{
    $this->config = config(\Harlleimazetti\Ci4tools\Config\Ci4toolsConfig::class);

    foreach($this->config as $property => $value) {
      $this->{$property} = $value;
    }
	}
}

/* Fim do arquivo Route.php */
/* Local: /Harlleimazetti/Ci4tools/Route/Route.php */
