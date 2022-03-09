<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('VENDOR_NAME') or define('VENDOR_NAME', 'harlleimazetti');
defined('PACKAGE_NAME') or define('PACKAGE_NAME', 'ci4tools');

class Install extends BaseCommand
{
  protected $group       = 'ci4tools';
  protected $name        = 'ci4tools:install';
  protected $description = 'Install Ci4Tools Admin.';

  protected $vendorFolder;
  protected $moduleFolder;
  protected $crudTemplatesFolder;
  protected $moduleAssetsFolder;
  protected $crudBaseFolder;
  protected $crudConfigFolder;
  protected $crudControllersBaseFolder;
  protected $crudModelsBaseFolder;
  protected $crudViewsBaseFolder;
  protected $crudEntitiesBaseFolder;
  protected $crudTemplatesBaseFolder;
  protected $crudValidationFolder;
  protected $controllersFolder;
  protected $modelsFolder;
  protected $entitiesFolder;
  protected $viewsFolder;
  protected $fieldsNotConfigurable;
  protected $fieldOptionsNotConfigurable;
  protected $fieldsConfigurable;

  function __construct()
  {
    $this->db = \Config\Database::connect();

    $this->vendorFolder 						  = ROOTPATH."vendor".DS.VENDOR_NAME.DS.PACKAGE_NAME.DS."src".DS;
    $this->moduleFolder 						  = ROOTPATH."ci4toolsadmin".DS;
    $this->crudTemplatesFolder 				= ROOTPATH."vendor".DS.VENDOR_NAME.DS.PACKAGE_NAME.DS."src".DS."Crud".DS."templates".DS;
    $this->crudBaseFolder 						= APPPATH."Crudbase".DS;
    $this->moduleAssetsFolder					= FCPATH."ci4toolsadmin".DS;

    $this->crudConfigFolder 					= $this->crudBaseFolder."Config".DS;
    $this->crudControllersBaseFolder 	= $this->crudBaseFolder."Controllers".DS;
    $this->crudModelsBaseFolder 			= $this->crudBaseFolder."Models".DS;
    $this->crudEntitiesBaseFolder 		= $this->crudBaseFolder."Entities".DS;
    $this->crudTemplatesBaseFolder 		= $this->crudBaseFolder."Templates".DS;
    $this->crudValidationFolder 		  = $this->crudBaseFolder."Validation".DS;

    $this->controllersFolder 					= APPPATH."Controllers".DS;
    $this->modelsFolder 							= APPPATH."Models".DS;
    $this->entitiesFolder 						= APPPATH."Entities".DS;
    $this->viewsFolder     						= APPPATH."Views".DS;

    $this->fieldsNotConfigurable        = ['created_at', 'updated_at', 'deleted_at'];
    $this->fieldOptionsNotConfigurable  = ['name'];
  }
  
  public function run(array $params)
  {
    if (!is_dir($this->moduleFolder))	{ mkdir($this->moduleFolder); }
    if (!is_dir($this->crudBaseFolder))	{ mkdir($this->crudBaseFolder); }
    if (!is_dir($this->crudConfigFolder))	{ mkdir($this->crudConfigFolder); }
    if (!is_dir($this->crudControllersBaseFolder))	{ mkdir($this->crudControllersBaseFolder); }
    if (!is_dir($this->crudModelsBaseFolder))	{ mkdir($this->crudModelsBaseFolder); }
    if (!is_dir($this->crudEntitiesBaseFolder))	{ mkdir($this->crudEntitiesBaseFolder); }
    if (!is_dir($this->crudTemplatesBaseFolder))	{ mkdir($this->crudTemplatesBaseFolder); }
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
    $destinationAssets = FCPATH;
    $publisherAssets = new \CodeIgniter\Publisher\Publisher($sourceAssets, $destinationAssets);
    $publisherAssets->addPath('ci4toolsadmin');
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
    $destinationThemeAssetsFiles = FCPATH;
    $publisherThemeAssetsFiles = new \CodeIgniter\Publisher\Publisher($sourceThemeAssetsFiles, $destinationThemeAssetsFiles);
    $publisherThemeAssetsFiles->addPath('themes');
    $publisherThemeAssetsFiles->merge(true);

    /**
     * Publish Ci4tools System Themes Template Files
     */
    $sourceThemeTemplateFiles = $this->vendorFolder."Themes".DS."templates";
    $destinationThemeTemplateFiles = $this->crudTemplatesBaseFolder;
    $publisherThemeTemplateFiles = new \CodeIgniter\Publisher\Publisher($sourceThemeTemplateFiles, $destinationThemeTemplateFiles);
    $publisherThemeTemplateFiles->addPath('themes');
    $publisherThemeTemplateFiles->merge(true);

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
    $publisherConfigFiles->merge(true);
  }
}