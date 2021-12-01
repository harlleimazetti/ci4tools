<?php

namespace Ci4toolsadmin\Controllers;

class Dashboard extends Ci4toolsadmin\Controllers\BaseController
{
  protected $data;

  function __construct()
  {
    
  }

  public function index()
  {
    $this->data['page_title']       = 'Dashboard';
    $this->data['page_subtitle']    = 'Visão geral';
    $this->data['page_description'] = 'Dashboard';
    $this->data['page_icon']        = 'fal fa-globe';
    $this->data['body_id']          = 'body_dashboard';
    $this->data['system_area']      = 'Dashboard';
    $this->data['menus']            = $this->menus;
    $this->data['theme_options']    = [
      'show_header' => true,
      'show_nav_side' => true,
      'show_nav_top' => true,
      'show_footer' => true,
    ];

    $contents = array('dashboard');

    echo $this->showView(
      $theme_name     = $this->themeConfig->themeName,
      $theme_options  = $this->data['theme_options'],
      $contents       = $contents,
      $data           = $this->data,
    );
  }
}
