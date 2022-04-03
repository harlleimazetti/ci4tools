<?php

namespace App\Crudbase\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Psr\Log\LoggerInterface;

/**
 * Class MainController
 *
 * MainController extends the Codeigniter Default Controller
 * and has additional properties and methods used by Ci4tools.
 * It has the main configuration for the Ci4tools Controllers to work.
 * All Ci4tools Controllers Base extend from this MainController and depend
 * of its data and configuration. You can skip to extend the Controllers
 * for this class but you will need to adjust the code for not use
 * the data and configuration that are present in this class.
 *
 * For security be sure to declare any new methods as protected or private.
 */
class MainController extends Controller
{
  use ResponseTrait;
  
  /**
   * System menus mounted according to the area being acessed.
   *
   * @var array menus
   */
  protected $menus;

  /**
   * System Configuration Options.
   *
   * @var array config
   */
  protected $config;

  /**
   * System Tenant.
   *
   * @object tenant
   */
  protected $tenant;

  /**
   * Constructor.
   */
  public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
  {
    // Do Not Edit This Line
    parent::initController($request, $response, $logger);

    // Preload any models, libraries, etc, here.

    // E.g.: $this->session = \Config\Services::session();

    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');

    $this->config = $this->getConfig();
    $this->menus  = $this->mountMenu();
    $this->tenant = $this->defineTenant();

    define('UPLOADPATH', WRITEPATH.'uploads'.DIRECTORY_SEPARATOR);
  }

	protected function showView(
    string $theme_name = "default",
    array $theme_options = [],
    array $contents = [],
    array $data = []
  ) {
		$template = "";

		$theme_options['show_header'] && $template .= view('themes/'.$theme_name.'/header', $data);
		$theme_options['show_nav_side'] && $template .= view('themes/'.$theme_name.'/nav_side', $data);
		$theme_options['show_nav_top'] && $template .= view('themes/'.$theme_name.'/nav_top', $data);
		
    foreach ($contents as $content) {
		  //$template .= view($content, $data);
      $template .= view('themes/'.$theme_name.'/'.$content, $data);
		}

		$theme_options['show_footer'] && $template .= view('themes/'.$theme_name.'/footer', $data);

		return $template;
	}

  protected function mountMenu()
  {
    $menuArea = [];

    if (file_exists(APPPATH."Models/MenuModel.php")) {
      $menuModel = new \App\Models\MenuModel();
      $menus = $menuModel->oneToMany('menuitem')->findAll();

      foreach($menus as $menu) {
        foreach($menu->menuitem as $menuitem) {
          $menuArea[$menu->name][] = $menuitem;
        }
      }

      return $menuArea;
    }

    $menuArea['Menu principal'][] = (object)[
      'name' => 'Dashboard',
      'description' => 'Dashboard',
      'path' => 'dashboard',
      'icon' => 'fal fa-home',
      'tags' => 'dashboard home'
    ];

    return $menuArea;
  }

  protected function getConfig() {
    $config = config('Ci4tools');
    return $config;
  }

  protected function defineTenant() {
    $tenantModel = new \App\Models\TenantModel();
    $tenant = $tenantModel->find(3);
    return $tenant;
  }
}
