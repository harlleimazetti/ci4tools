<?php namespace Ci4toolsadmin\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Harlleimazetti\Ci4tools\Crud\Crud;
use \Harlleimazetti\Ci4tools\Route\Route;

class Routes extends \Ci4toolsadmin\Controllers\BaseController
{
  use ResponseTrait;

  protected $data;
  protected $route;
  protected $result = [];

  function __construct()
  {
    $this->route = new Route();
  }

  public function index()
  {
    $controllers = $this->route->loadControllers();

    $this->data['page_title']       = 'Controllers';
    $this->data['page_subtitle']    = 'Configuração dos Controladores do sistema';
    $this->data['page_description'] = 'Parametrização das informações de identificação (labels, descrição) dos Controllers e seus métodos';
    $this->data['page_icon']        = 'fal fa-globe';
    $this->data['body_id']          = 'body_table';
    $this->data['system_area']      = 'Tabelas';
    $this->data['menus']            = $this->menus;
    $this->data['controllers']      = $controllers;

    $this->data['theme_options']    = [
      'show_header' => true,
      'show_nav_primary' => true,
      'show_nav_secondary' => true,
      'show_footer' => true,
    ];

    $contents = array('ControllerList');

    echo $this->showView(
      $theme_name     = $this->config->themeAdminName,
      $theme_options  = $this->data['theme_options'],
      $contents       = $contents,
      $data           = $this->data,
    );
  }

  public function saveconfig() {
    $table = $this->request->getPost('table');
    $options = $this->request->getPost();

    $this->crud->setTable($table);

    $this->result = $this->crud->saveTableConfig($table, $options);

    if ($this->result->success === false) {
       return $this->fail($this->result, 400);
    }

		return $this->respond($this->result, 200);
  }
}
