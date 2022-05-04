<?php namespace Harlleimazetti\Ci4tools\Config;

use \CodeIgniter\Config\BaseConfig;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('VENDOR_NAME') or define('VENDOR_NAME', 'harlleimazetti');
defined('PACKAGE_NAME') or define('PACKAGE_NAME', 'ci4tools');
defined('CRUD_BASE_FOLDER') or define('CRUD_BASE_FOLDER', APPPATH."Crudbase".DS);
defined('VENDOR_FOLDER') or define('VENDOR_FOLDER', ROOTPATH."vendor".DS.VENDOR_NAME.DS.PACKAGE_NAME.DS."src".DS);
defined('CRUD_TEMPLATES_FOLDER') or define('CRUD_TEMPLATES_FOLDER', ROOTPATH."vendor".DS.VENDOR_NAME.DS.PACKAGE_NAME.DS."src".DS."Crud".DS."Templates".DS);

class Ci4toolsConfig extends BaseConfig
{
    /**
    * CRUD CONFIG
    */
    public $vendorFolder 						      = VENDOR_FOLDER;
    public $crudTemplatesFolder 				  = CRUD_TEMPLATES_FOLDER;
    public $crudBaseFolder 						    = CRUD_BASE_FOLDER;
    public $moduleFolder 						      = ROOTPATH."ci4toolsadmin".DS;
    public $moduleAssetsFolder					  = ROOTPATH."public".DS."ci4toolsadmin".DS;
    
		public $crudConfigFolder 					    = CRUD_BASE_FOLDER."Config".DS;
		public $crudControllersBaseFolder 	  = CRUD_BASE_FOLDER."Controllers".DS;
    public $crudEntitiesBaseFolder 		    = CRUD_BASE_FOLDER."Entities".DS;
    public $crudModelsBaseFolder 			    = CRUD_BASE_FOLDER."Models".DS;
    public $crudTemplatesBaseFolder		    = CRUD_BASE_FOLDER."Templates".DS;
    public $crudValidationFolder 		      = CRUD_BASE_FOLDER."Validation".DS;

    public $controllersFolder 					  = APPPATH."Controllers".DS;
		public $modelsFolder 							    = APPPATH."Models".DS;
    public $entitiesFolder 						    = APPPATH."Entities".DS;
    public $viewsFolder     						  = APPPATH."Views".DS;

    public $themesTemplatesFolder         = VENDOR_FOLDER."Themes".DS."Templates".DS."themes".DS;
    public $themesTemplatesBaseFolder 	  = CRUD_BASE_FOLDER."Templates".DS;

    public $tablesNotConfigurable         = ['user', 'group', 'permission', 'permission_user', 'permission_group'];
    public $fieldsNotConfigurable         = ['created_at', 'updated_at', 'deleted_at'];
    public $fieldOptionsNotConfigurable   = ['name'];

    /**
    * ROUTE CONFIG
    */
    public $routeControllersConfigFolder  = CRUD_BASE_FOLDER."Route".DS."Config".DS."Controllers".DS;
    public $routeRoutesConfigFolder       = CRUD_BASE_FOLDER."Route".DS."Config".DS."Routes".DS;

    public $controllersNotConfigurable    = ['BaseController', 'User', 'Group', 'Permission'];

}