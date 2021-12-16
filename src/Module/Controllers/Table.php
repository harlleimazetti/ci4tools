<?php

namespace Ci4toolsadmin\Controllers;

use \Harlleimazetti\Ci4tools\Crud\Crud;

class Table extends \Ci4toolsadmin\Controllers\BaseController
{
  protected $data;
  protected $crud;

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

    $this->crud->setTable($table);

    $options = $this->request->getPost();

    unset($options['table']);

    $optionsKeys = array_keys($options);

    $countOptions = count($options['name']);

    for ($i = 0; $i < $countOptions; $i++) {
      $newConfig[] = array_combine($optionsKeys, array_column($options, $i));
    }
    
    $tableFields = $this->crud->getFieldsConfigurable();
    $tableConfig = $this->crud->getTableConfig();
    $tableConfig = json_decode(json_encode($tableConfig), true);

    foreach($tableConfig as $key => $config) {
      foreach($newConfig as $newConf) {
        if ($config['name'] == $newConf['name']) {
          $tableConfig[$key] = array_merge($config, $newConf);
        }
      }
    }

    $this->crud->saveTableConfig($table, $tableConfig);
  }
}
