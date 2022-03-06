<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Install extends BaseCommand
{
  protected $group       = 'ci4tools';
  protected $name        = 'ci4tools:install';
  protected $description = 'Install Ci4Tools Admin.';

  protected $vendorFolder;
  protected $moduleFolder;
  protected $crudTemplatesFolder;
  protected $crudBaseFolder;
  protected $crudConfigFolder;
  protected $crudControllersBaseFolder;
  protected $crudModelsBaseFolder;
  protected $crudEntitiesBaseFolder;
  protected $crudViewsBaseFolder;
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

    $this->crudConfigFolder 					= $this->crudBaseFolder."Config".DS;
    $this->crudControllersBaseFolder 	= $this->crudBaseFolder."Controllers".DS;
    $this->crudModelsBaseFolder 			= $this->crudBaseFolder."Models".DS;
    $this->crudEntitiesBaseFolder 		= $this->crudBaseFolder."Entities".DS;
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
     * Publish Ci4toolsadmin Module Assets
     */
    $sourceAssets = $this->vendorFolder."Module".DS."public";
    $destinationAssets = FCPATH;
    $publisherAssets = new \CodeIgniter\Publisher\Publisher($sourceAssets, $destinationAssets);
    $publisherAssets->addPath('ci4toolsadmin');
    $publisherAssets->merge(true);

    /**
     * Publish Crudbase Main Controller
     */
    $sourceMainController = $this->vendorFolder."Crud";
    $destinationMainController = $this->crudControllersBaseFolder;
    $publisherMainController = new \CodeIgniter\Publisher\Publisher($sourceMainController, $destinationMainController);
    $publisherMainController->addPath('MainController.php');
    $publisherMainController->merge(true);
  }
}