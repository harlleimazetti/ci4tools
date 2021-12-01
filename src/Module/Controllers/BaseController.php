<?php

namespace Ci4toolsadmin\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
  /**
   * Instance of the main Request object.
   *
   * @var CLIRequest|IncomingRequest
   */
  protected $request;

  /**
   * An array of helpers to be loaded automatically upon
   * class instantiation. These helpers will be available
   * to all other controllers that extend BaseController.
   *
   * @var array
   */
  protected $helpers = [];

  /**
   * System menus mounted according to the area being acessed.
   *
   * @var array menus
   */
  protected $menus;

  /**
   * System Theme Configuration Options.
   *
   * @var array themeConfig
   */
  protected $themeConfig;

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

    $this->themeConfig = $this->getThemeConfig();
    $this->menus = $this->mountMenu();
  }

	protected function showView(
    string $theme_name = "default",
    array $theme_options = [],
    array $contents = [],
    array $data = []
  ) {
		$template = "";

		$theme_options['show_header'] && $template .= view('/Ci4tools/Views/themes/'.$theme_name.'/header', $data);
		$theme_options['show_nav_primary'] && $template .= view('/Ci4tools/Views/themes/'.$theme_name.'/nav_primary', $data);
		$theme_options['show_nav_secondary'] && $template .= view('/Ci4tools/Views/themes/'.$theme_name.'/nav_secondary', $data);
		
    foreach ($contents as $content) {
		  //$template .= view($content, $data);
      $template .= view('/Ci4tools/Views/themes/'.$theme_name.'/'.$content, $data);
		}

		$theme_options['show_footer'] && $template .= view('/Ci4tools/Views/themes/'.$theme_name.'/footer', $data);

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

  protected function getThemeConfig() {
    $themeConfig = config('Theme');
    return $themeConfig;
  }
}
