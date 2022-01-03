<?php namespace Ci4toolsadmin\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Harlleimazetti\Ci4tools\Crud\Crud;

class Table extends \Ci4toolsadmin\Controllers\BaseController
{
  use ResponseTrait;

  protected $data;
  protected $crud;
  protected $result = [];

  function __construct()
  {
    $this->crud = new Crud();
  }

  public function index($table = "")
  {
    $this->crud->setTable($table);
    
    $tableFields = $this->crud->getFieldsConfigurable();
    $tableConfig = $this->crud->getTableConfig();

    $this->data['page_title']       = 'Tabelas';
    $this->data['page_subtitle']    = 'Configuração das tabelas do banco de dados';
    $this->data['page_description'] = 'Parametrização de campos, relacionamentos, labels e formato das colunas da tabela';
    $this->data['page_icon']        = 'fal fa-globe';
    $this->data['body_id']          = 'body_table';
    $this->data['system_area']      = 'Tabelas';
    $this->data['menus']            = $this->menus;

    $this->data['table']            = $table;
    $this->data['tableFields']      = $tableFields;
    $this->data['tableConfig']      = $tableConfig;

    $this->data['theme_options']    = [
      'show_header' => true,
      'show_nav_primary' => true,
      'show_nav_secondary' => true,
      'show_footer' => true,
    ];

    $contents = array('table');

    echo $this->showView(
      $theme_name     = $this->themeConfig->themeAdminName,
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
