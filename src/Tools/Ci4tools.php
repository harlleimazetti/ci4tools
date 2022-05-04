<?php namespace Harlleimazetti\Ci4tools\Tools;

use \CodeIgniter\CLI\CLI;
use \Harlleimazetti\Ci4tools\Templateparser\TemplateParser;
use \Harlleimazetti\Ci4tools\Crud\CrudTrait;
use \Harlleimazetti\Ci4tools\Route\RouteTrait;
use CodeIgniter\Config\Factories;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('VENDOR_NAME') or define('VENDOR_NAME', 'harlleimazetti');
defined('PACKAGE_NAME') or define('PACKAGE_NAME', 'ci4tools');

class Ci4tools extends \CodeIgniter\Controller {
  use CrudTrait, RouteTrait;

	function __construct()
	{

	}

  public function install()
  {
		if (!is_dir($this->moduleFolder))	{ mkdir($this->moduleFolder); }
    if (!is_dir($this->crudBaseFolder))	{ mkdir($this->crudBaseFolder); }
		if (!is_dir($this->crudConfigFolder))	{ mkdir($this->crudConfigFolder); }
		if (!is_dir($this->crudControllersBaseFolder))	{ mkdir($this->crudControllersBaseFolder); }
		if (!is_dir($this->crudModelsBaseFolder))	{ mkdir($this->crudModelsBaseFolder); }
		if (!is_dir($this->crudEntitiesBaseFolder))	{ mkdir($this->crudEntitiesBaseFolder); }
    if (!is_dir($this->themesTemplatesBaseFolder))	{ mkdir($this->themesTemplatesBaseFolder); }
    if (!is_dir($this->crudValidationFolder))	{ mkdir($this->crudValidationFolder); }

    /**
     * Publish Ci4toolsadmin Module
     */
    $source = $this->vendorFolder."Module";
    $destinationModule = $this->moduleFolder;
    $publisher = new \CodeIgniter\Publisher\Publisher($source, $destinationModule);
    $publisher->addPath('Controllers');
    $publisher->addPath('Entities');
    $publisher->addPath('Models');
    $publisher->addPath('Views');
    $publisher->merge(true);

    /**
     * Publish Ci4toolsadmin Admin Assets
     */
    $sourceAssets = $this->vendorFolder."Module".DS."public";
    $destinationAssets = ROOTPATH."public";
    $publisherAssets = new \CodeIgniter\Publisher\Publisher($sourceAssets, $destinationAssets);
    $publisherAssets->addPath('assets');
    $publisherAssets->addPath('ci4toolsadmin');
    $publisherAssets->addPath('localisation');
    $publisherAssets->merge(true);

    /**
     * Publish Ci4tools System Themes View Files
     */
    $sourceThemeViewFiles = $this->vendorFolder."Themes".DS."Views";
    $destinationThemeViewFiles = APPPATH."Views";
    $publisherThemeViewFiles = new \CodeIgniter\Publisher\Publisher($sourceThemeViewFiles, $destinationThemeViewFiles);
    $publisherThemeViewFiles->addPath('themes');
    $publisherThemeViewFiles->merge(true);

    /**
     * Publish Ci4tools System Themes Assets Files
     */
    $sourceThemeAssetsFiles = $this->vendorFolder."Themes".DS."assets";
    $destinationThemeAssetsFiles = ROOTPATH."public";
    $publisherThemeAssetsFiles = new \CodeIgniter\Publisher\Publisher($sourceThemeAssetsFiles, $destinationThemeAssetsFiles);
    $publisherThemeAssetsFiles->addPath('themes');
    $publisherThemeAssetsFiles->merge(true);

    /**
     * Publish Ci4tools System Themes Template Files
     */
    $sourceThemeTemplateFiles = $this->vendorFolder."Themes".DS."templates";
    $destinationThemeTemplateFiles = $this->themesTemplatesBaseFolder;
    $publisherThemeTemplateFiles = new \CodeIgniter\Publisher\Publisher($sourceThemeTemplateFiles, $destinationThemeTemplateFiles);
    $publisherThemeTemplateFiles->addPath('themes');
    $publisherThemeTemplateFiles->merge(true);

    /**
     * Publish Ci4tools CRUD Base Template Files
     */
    $sourceCrudTemplateFiles = $this->crudTemplatesFolder;
    $destinationCrudTemplateFiles = $this->crudTemplatesBaseFolder;
    $publisherCrudTemplateFiles = new \CodeIgniter\Publisher\Publisher($sourceCrudTemplateFiles, $destinationCrudTemplateFiles);
    $publisherCrudTemplateFiles->addPath('base');
    $publisherCrudTemplateFiles->merge(true);

    /**
     * Publish Crudbase Main Controller
     */
    $sourceMainController = $this->vendorFolder."Crud";
    $destinationMainController = $this->crudControllersBaseFolder;
    $publisherMainController = new \CodeIgniter\Publisher\Publisher($sourceMainController, $destinationMainController);
    $publisherMainController->addPath('MainController.php');
    $publisherMainController->merge(true);

    /**
     * Publish Ci4tools Config Files
     */
    $sourceConfigFiles = $this->vendorFolder."Module".DS."Config";
    $destinationConfigFiles = APPPATH.'Config';
    $publisherConfigFiles = new \CodeIgniter\Publisher\Publisher($sourceConfigFiles, $destinationConfigFiles);
    $publisherConfigFiles->addPath('Ci4tools.php');
    $publisherConfigFiles->addPath('Ci4toolsRoutes.php');
    $publisherConfigFiles->merge(false);

    /**
     * Publish Auth Filters
     */
    $sourceAuthFiltersFiles = $this->vendorFolder."Auth";
    $destinationAuthFiltersFiles = APPPATH;
    $publisherAuthFiltersFiles = new \CodeIgniter\Publisher\Publisher($sourceAuthFiltersFiles, $destinationAuthFiltersFiles);
    $publisherAuthFiltersFiles->addPath('Filters');
    $publisherAuthFiltersFiles->merge(true);
  }
}

/* Fim do arquivo Ci4tools.php */
/* Local: ./Harlleimazetti/Ci4tools/Tools/Ci4tools.php */
