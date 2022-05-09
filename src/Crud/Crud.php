<?php namespace Harlleimazetti\Ci4tools\Crud;

use \Harlleimazetti\Ci4tools\Crud\CrudTrait;

class Crud extends \CodeIgniter\Controller {
  use CrudTrait;

	function __construct()
	{
    CrudTrait::init();
    /*
    $this->db = \Config\Database::connect();
    $this->parser = new TemplateParser();
    $this->config = config(\Harlleimazetti\Ci4tools\Config\Ci4toolsConfig::class);

    foreach($this->config as $property => $value) {
      $this->{$property} = $value;
    }

    $this->themesFolders = $this->getDirectoryFoldersNames($this->themesTemplatesBaseFolder."themes".DS);
    */
	}
}

/* Fim do arquivo Crud.php */
/* Local: /Harlleimazetti/Ci4tools/Crud/Crud.php */
