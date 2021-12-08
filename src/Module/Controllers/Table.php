<?php

namespace Ci4toolsadmin\Controllers;

class Table extends \Ci4toolsadmin\Controllers\BaseController
{
  protected $data;

  function __construct()
  {
    
  }

  public function index()
  {
    $this->data['page_title']       = 'Tabelas';
    $this->data['page_subtitle']    = 'Configuração das tabelas do banco de dados';
    $this->data['page_description'] = 'Parametrização de campos, relacionamentos, labels e formato das colunas da tabela';
    $this->data['page_icon']        = 'fal fa-globe';
    $this->data['body_id']          = 'body_table';
    $this->data['system_area']      = 'Tabelas';
    $this->data['menus']            = $this->menus;
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
}
