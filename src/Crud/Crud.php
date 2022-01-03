<?php namespace Harlleimazetti\Ci4tools\Crud;

use \CodeIgniter\CLI\CLI;
use \Harlleimazetti\Ci4tools\Templateparser\TemplateParser;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('VENDOR_NAME') or define('VENDOR_NAME', 'harlleimazetti');
defined('PACKAGE_NAME') or define('PACKAGE_NAME', 'ci4tools');

class Crud extends \CodeIgniter\Controller {
	protected $db;
	protected $tables;
	protected $table;
	protected $fields;
	protected $keys;
	protected $indexes;
  protected $tableConfig;
	protected $recordFields;
	protected $recordAllowedFields;
  protected $recordFormFields;
	protected $formFields;
	protected $tableHeader;
	protected $templateVars;
  protected $vendorFolder;
  protected $moduleFolder;
  protected $crudBaseFolder;
	protected $controllersFolder;
	protected $modelsFolder;
	protected $viewsFolder;
	protected $entitiesFolder;
	protected $crudControllersBaseFolder;
	protected $crudModelsBaseFolder;
	protected $crudViewsBaseFolder;
	protected $crudEntitiesBaseFolder;
  protected $crudValidationFolder;
  protected $crudConfigFolder;
	protected $crudTemplatesFolder;
  protected $fieldsConfigurable;
  protected $fieldsNotConfigurable;
  protected $fieldOptionsNotConfigurable;
  protected $visibleFields;
  protected $listVisibleFields;
  protected $listVisibleFieldsLabel;
  protected $listVisibleFieldsConfig;
  protected $formVisibleFields;
  protected $formVisibleFieldsLabel;
  protected $formVisibleFieldsConfig;
  protected $parser;
  protected $result;

	function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->tables = $this->db->listTables();
    $this->parser = new TemplateParser();

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
    
		//$this->load->helper('form');
		//$this->load->helper('custom_form');
	}

  public function install()
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
    $publisher->merge(false);

    /**
     * Publish Ci4toolsadmin Module Assets
     */
    $sourceAssets = $this->vendorFolder."Module".DS."public";
    $destinationAssets = FCPATH;
    $publisherAssets = new \CodeIgniter\Publisher\Publisher($sourceAssets, $destinationAssets);
    $publisherAssets->addPath('ci4toolsadmin');
    $publisherAssets->merge(false);

    /**
     * Publish Crudbase Main Controller
     */
    $sourceMainController = $this->vendorFolder."Crud";
    $destinationMainController = $this->crudControllersBaseFolder;
    $publisherMainController = new \CodeIgniter\Publisher\Publisher($sourceMainController, $destinationMainController);
    $publisherMainController->addPath('MainController.php');
    $publisherMainController->merge(false);
  }

  public function setTable($table = "") {
		if (empty($table)) {
      throw new Exception('Table name can`t be null');
		}

    if (!$this->db->tableExists($table)) {
			throw new Exception('Table not found');
		}

    $this->setTableInfo($table);
  }

	protected function setTableInfo($table) {
		$this->table		      = $table;
		$this->fields		      = $this->db->getFieldData($this->table);
		$this->keys			      = $this->db->getForeignKeyData($this->table);
		$this->indexes        = $this->db->getIndexData($this->table);
    
    $this->setTableConfig($this->table);
	}

  protected function setTableConfig($table) {
    $fileConfigPath = $this->crudConfigFolder.$table.".json";

    if (!file_exists($fileConfigPath)) {
      return null;
    }

    $this->tableConfig = json_decode(file_get_contents($fileConfigPath));

    $this->setFieldsConfigurable();

    $this->visibleFields = $this->loadVisibleFields($this->table);

    $this->listVisibleFields = $this->loadVisibleFields($this->table);
    $listVisibleFieldsConfig = $this->loadListVisibleFieldsConfig($this->table);

    if (!empty($listVisibleFieldsConfig)) {
      $this->listVisibleFieldsConfig = array_values($listVisibleFieldsConfig);
      $this->listVisibleFieldsLabel = array_column($this->listVisibleFieldsConfig, 'label');
    }

    $this->formVisibleFields = $this->loadVisibleFields($this->table);
    $formVisibleFieldsConfig = $this->loadFormVisibleFieldsConfig($this->table);

    if (!empty($formVisibleFieldsConfig)) {
      $this->formVisibleFieldsConfig = array_values($formVisibleFieldsConfig);
      $this->formVisibleFieldsLabel = array_column($this->formVisibleFieldsConfig, 'label');
    }
  }

  protected function setFieldsConfigurable() {
    $fields = json_decode(json_encode($this->fields), true);
    $fieldsConfigurable = array_column($fields, 'name');
    $fieldsConfigurable = array_diff($fieldsConfigurable, $this->fieldsNotConfigurable);
    $fieldsConfigurable = array_intersect_key($this->fields, $fieldsConfigurable);
    $this->fieldsConfigurable  = $fieldsConfigurable;
  }

  public function getTableConfig() {
    return $this->tableConfig;
  }

  public function getFields() {
    return $this->fields;
  }

  public function getVisibleFields() {
    return $this->visibleFields;
  }

  public function getListVisibleFields() {
    return $this->listVisibleFields;
  }

  public function getFormVisibleFields() {
    return $this->formVisibleFields;
  }

  public function getFieldsNotConfigurable() {
    return $this->fieldsNotConfigurable;
  }

  public function getFieldsConfigurable() {
    return $this->fieldsConfigurable;
  }

	public function tableinfo($table = "") {
		if (empty($table)) {
			CLI::error("TABLEINFO (ERROR): Please, type a table name.");
			exit;
		}
		
		if (!$this->db->tableExists($table)) {
			CLI::error("TABLEINFO (ERROR): Table not found: ". CLI::color($table, 'white'));
			exit;
		}

		$this->setTableInfo($table);

		echo "\r\n";
		echo "> TABLE NAME: ".$this->color($this->table, "green")."\r\n";
		echo "\r\n\r\n";

		echo "> FIELDS \r\n";
		echo "\r\n";
		foreach ($this->fields as $field) {
			echo STR_PAD($field->name, 30);
			echo STR_PAD($field->type, 20);
			echo STR_PAD($field->max_length, 10);
			if ($field->primary_key) {
				echo $this->color(STR_PAD("PRIMARY", 20), "orange");
				echo STR_PAD("-", 20);
				echo STR_PAD("-", 20);
			} else {
				$k = array_search($field->name, array_column($this->keys, 'column_name'));
				if (is_numeric($k)) {
					echo $this->color(STR_PAD("FOREIGN KEY", 20), "orange");
					echo $this->color(STR_PAD($this->keys[$k]->foreign_table_name,20), "green");
					echo $this->color(STR_PAD($this->keys[$k]->foreign_column_name,20), "blue");
				}	else {
					echo STR_PAD("-", 20);
					echo STR_PAD("-", 20);
					echo STR_PAD("-", 20);
				}
			}
			echo "\r\n";
		}
		echo "\r\n";


		echo "> INDEXES \r\n";
		echo "\r\n";

		foreach ($this->indexes as $index) {
			$color = $index->name == "PRIMARY" ? "orange" : "white";

			echo $this->color(STR_PAD($index->name, 15), $color);
			echo $this->color(STR_PAD($index->type, 15), $color);
			$fields = "";
			foreach($index->fields as $field) {
				$fields .= $field.", ";
			}
			echo $this->color(STR_PAD($fields, 15), "blue");
			echo "\r\n";
		}
	}

	public function create($tables = "") {
		if (!empty($tables))
		{
			$pos = strpos($tables, ",");
			if ($pos === false)
			{
				$this->tables = array($tables);
			}
			else
			{
				$this->tables = array_map('trim', explode(',', $tables));
			}
		}

		foreach ($this->tables as $table)
		{
			if (!$this->db->tableExists($table))
			{
				echo $this->color("ERROR: TABLE NOT FOUND - ", "red").$table;
				echo "\r\n";
				break;
			}

			$this->setTableInfo($table);
			$tableConfig = array();
			$n = 0;

      $tableKeys = json_decode(json_encode($this->keys), true);

			foreach ($this->fields as $field)
			{
				$type			    = "text";
				$show			    = "Y";
        $show_on_list = "Y";
        $show_on_form = "Y";
				$allowed	    = "Y";

				if ($field->name == "id") {
					$type			    = "hidden";
					$show			    = "Y";
          $show_on_list = "Y";
          $show_on_form = "Y";
					$allowed	    = "Y";
				}

				if ($field->name == "created_at" || $field->name == "updated_at" || $field->name == "deleted_at") {
					$type			    = "hidden";
					$show			    = "N";
          $show_on_list = "N";
          $show_on_form = "N";
					$allowed	    = "N";
				}

				if ($field->name == "password") {
					$type			    = "hidden";
					$show			    = "N";
          $show_on_list = "N";
          $show_on_form = "N";
					$allowed	    = "N";
				}

        $key = array_search($field->name, array_column($tableKeys, 'column_name'));

        if (!(empty($key) && $key !== 0)) {
          $fk = $this->keys[$key];
        } else {
          $fk = NULL;
        }

				$tableConfig[] = array(
					"table"				        => $table,
          "name"				        => $field->name,
					"label"				        => $field->name,
          "nullable"		        => $field->nullable,
          "required"		        => !$field->nullable,
          "default"		          => $field->default,
          "placeholder"         => $field->name,
          "value"               => '',
          "min"                 => '',
          "max"                 => '',
          "increment"           => '',
					"order"				        => $n,
					"show"				        => $show,
          "show_on_list"        => $show_on_list,
          "show_on_form"        => $show_on_form,
					"type"				        => $type,
					"allowed"			        => $allowed,
          "foreign_table_name"  => !empty($fk) ? $fk->foreign_table_name : '',
          "foreign_column_name" => !empty($fk) ? $fk->foreign_column_name : '',
          "foreign_column_show" => [],
          "options" 		        => [],
          "relation_type"       => "",
					"multiple"		        => "N",
					"field_class"         => "form-control",
					"label_class"         => "col-sm-2 control-label"
				);
				$n++;
			}

      //print_r($tableConfig); exit;

			echo $this->color("CREATING CONFIG FILE - ", "green").$table.".json";
			echo "\r\n";

			$tableConfig = json_encode($tableConfig);
			$tableConfig = $this->indent($tableConfig);
			$fileConfigPath = $this->crudConfigFolder.$table.".json";

			if (!file_exists($fileConfigPath)) {
				file_put_contents($fileConfigPath, $tableConfig);
			}
		}
	}

	public function make($tables = "")
	{
		if (!empty($tables))
		{
			$pos = strpos($tables, ",");
			if ($pos === false)
			{
				$this->tables = array($tables);
			}
			else
			{
				$this->tables = array_map('trim', explode(',', $tables));
			}
		}

		if (!is_dir($this->crudConfigFolder))
		{
			echo $this->color("ERROR: CONFIG/CRUD FOLDER NOT FOUND", "red");
			echo "\r\n";
			exit;
		}

		foreach ($this->tables as $table)
		{
			if (!$this->db->tableExists($table))
			{
				echo $this->color("ERROR: TABLE NOT FOUND - ", "red").$table;
				echo "\r\n";
				break;
			}

			echo "Making CRUD for table (".$table.")"."\r\n";

			echo "Setting table info"."\r\n";
			$this->setTableInfo($table);

			echo "Retrieving table config"."\r\n";

			$fileConfigPath = $this->crudConfigFolder.$table.".json";

			if (!file_exists($fileConfigPath)) {
				echo $this->color("ERROR: CONFIG FILE NOT FOUND - ", "red").$table;
				echo "\r\n";
				break;
			}

			echo "Making record fields list"."\r\n";
			$this->recordFields	= $this->makeRecordFieldsString();

			echo "Making record allowed fields list"."\r\n";
			$this->recordAllowedFields	= $this->makeRecordAllowedFieldsString();

			echo "Making record table header"."\r\n";
			$this->tableHeader	= $this->makeRecordHtmlTableHeader();

      echo "Making record HTML form fields"."\r\n";
			$this->recordFormFields = $this->makeRecordFormFields();

			echo "Setting template vars"."\r\n";
			$this->templateVars = $this->setTemplateVars();

			echo "Making Controller files"."\r\n";
			$this->makeControllerFiles();

			echo "Making Validation files"."\r\n";
			$this->makeValidationFiles();

      echo "Making Model files"."\r\n";
			$this->makeModelFiles();

			echo "Making View List files"."\r\n";
			$this->makeViewListFiles();

      echo "Making View Form files"."\r\n";
			$this->makeViewFormFiles();

			echo "End of table config"."\r\n";
			echo ".:."."\r\n";

			//exit;
		}
	}

	public function config($tables = "")
  {
		if (!empty($tables)) {
			$pos = strpos($tables, ",");
			if ($pos === false) {
				$this->tables = array($tables);
			} else {
				$this->tables = array_map('trim', explode(',', $tables));
			}
		}

		if (!is_dir($this->crudConfigFolder)) {
      CLI::error("ERROR: CRUD Config folder not found");
			exit;
		}

		foreach ($this->tables as $table)
    {
			if (!$this->db->tableExists($table)) {
        CLI::error("TABLE CONFIG (ERROR): Table not found: ". CLI::color($table, 'green'));
				exit;
			}

      CLI::write("Edit CRUD Config file for table: ". CLI::color($table, 'green'), 'white');

      CLI::write("Retrieving table config");
			$fileConfigPath = $this->crudConfigFolder.$table.".json";

			if (!file_exists($fileConfigPath)) {
        CLI::error("ERROR: Config file not found: ". CLI::color($table, 'green'));
				exit;
			}
			
			$this->tableConfig = json_decode(file_get_contents($fileConfigPath));

      $tableConfig = json_decode(json_encode($this->tableConfig), true);
      $tableFields = array_column($tableConfig, 'name');
      $tableFields = array_diff($tableFields, $this->fieldsNotConfigurable);

      $selectedField = CLI::promptByKey("Selecione o campo que deseja configurar", $tableFields);
      
      $configOptions = array_keys($tableConfig[$selectedField]);
      $configOptions = array_diff($configOptions, $this->fieldOptionsNotConfigurable);
      
      foreach($configOptions as $i => $option)
      {
        $promptOptions = $tableConfig[$selectedField][$option];

        if ($option === 'multiple' || $option === 'show' || $option === 'allowed') {
          $promptOptions = ['Y' => 'Yes', 'N' => 'No'];
          $tableConfig[$selectedField][$option] = CLI::promptByKey($option, $promptOptions);
        } else {
          $tableConfig[$selectedField][$option] = CLI::prompt($option, $promptOptions);
        }
      }

			$tableConfig = json_encode($tableConfig);
			$tableConfig = $this->indent($tableConfig);
			$fileConfigPath = $this->crudConfigFolder.$table.".json";

			file_put_contents($fileConfigPath, $tableConfig);
    }
	}

  public function saveTableConfig($table, $options) {
    unset($options['table']);
    
    $optionsKeys = array_keys($options);
    $countOptions = count($options['name']);

    for ($i = 0; $i < $countOptions; $i++) {
      $newConf[] = array_combine($optionsKeys, array_column($options, $i));
    }
    
    //$tableFields = $this->crud->getFieldsConfigurable();
    $tableConfig = $this->getTableConfig();
    $tableConfig = json_decode(json_encode($tableConfig), true);

    foreach($tableConfig as $key => $config) {
      foreach($newConf as $newConfig) {
        if ($config['name'] == $newConfig['name']) {
          $tableConfig[$key] = array_merge($config, $newConfig);
        }
      }
    }

    $tableConfig = json_encode($tableConfig);
    $tableConfig = $this->indent($tableConfig);
    $fileConfigPath = $this->crudConfigFolder.$table.".json";

    try {
      file_put_contents($fileConfigPath, $tableConfig);
      $this->result['success'] = true;
      $this->result['messages'][] = 'Dados salvos com sucesso';
      $this->result['errors'] = [];
    } catch (Exception $e) {
      $this->result['success'] = false;
      $this->result['messages'][] = 'Problemas na gravação do dados';
      $this->result['errors'] = $e->getMessage();
    }
    
    return (object)$this->result;
  }

	protected function loadVisibleFields($table = "")
  {
		if (empty($table)) {
      return null;
		}

		if (!is_dir($this->crudConfigFolder)) {
      //CLI::error("ERROR: CRUD Config folder not found");
			return null;
		}

    if (!$this->db->tableExists($table)) {
      //CLI::error("TABLE CONFIG (ERROR): Table not found: ". CLI::color($table, 'green'));
      return null;
    }

    $fileConfigPath = $this->crudConfigFolder.$table.".json";

    if (!file_exists($fileConfigPath)) {
      //CLI::error("ERROR: Config file not found: ". CLI::color($table, 'green'));
      return null;
    }
    
    $this->tableConfig = json_decode(file_get_contents($fileConfigPath));

    $tableConfig = json_decode(json_encode($this->tableConfig), true);

    /* Find fields that area displayable: show = Y */
    $displayableFields = array_keys(array_column($tableConfig, 'show'), 'Y');

    /* Intersect displyable fields to filter $tableConfig array */
    $b = array_intersect_key($tableConfig, array_flip($displayableFields));

    /* Retrieve array with fields names and filter for return only configurable fields */
    $tableFields  = array_column($b, 'name');
    $tableFields  = array_diff($tableFields, $this->fieldsNotConfigurable);

    return $tableFields;
	}

  protected function loadListVisibleFieldsConfig($table = "") {
		if (empty($table)) {
      return null;
		}

    $tableConfig = json_decode(json_encode($this->tableConfig), true);

    if (empty($tableConfig)) {
      return null;
    }

    /* Find fields that area displayable: show = Y */
    $displayableFields = array_keys(array_column($tableConfig, 'show'), 'Y');

    /* Intersect displyable fields to filter $this->tableConfig array */
    $listVisibleFieldsConfig = array_intersect_key($this->tableConfig, array_flip($displayableFields));

    return $listVisibleFieldsConfig;
  }

  protected function loadFormVisibleFieldsConfig($table = "") {
		if (empty($table)) {
      return null;
		}

    $tableConfig = json_decode(json_encode($this->tableConfig), true);

    if (empty($tableConfig)) {
      return null;
    }

    /* Find fields that area displayable: show_on_form = Y */
    $displayableFields = array_keys(array_column($tableConfig, 'show_on_form'), 'Y');

    /* Intersect displyable fields to filter $this->tableConfig array */
    $formVisibleFieldsConfig = array_intersect_key($this->tableConfig, array_flip($displayableFields));

    return $formVisibleFieldsConfig;
  }

	protected function extrair_conteudo($conteudo, $tag_inicio, $tag_fim) {
		$pos_inicio = strpos($conteudo, $tag_inicio);
		$pos_fim = strpos($conteudo, $tag_fim);
		if ($pos_inicio AND $pos_fim) {
			$pos_inicio = strpos($conteudo, $tag_inicio) + strlen($tag_inicio);
			$tam = $pos_fim - $pos_inicio;
			return substr($conteudo, $pos_inicio, $tam);
		} else {
			return false;
		}
	}

	protected function inserir_conteudo($conteudo, $conteudo_novo, $tag_inicio, $tag_fim) {
		$pos_inicio = strpos($conteudo, $tag_inicio);
		$pos_fim = strpos($conteudo, $tag_fim);
		if ($pos_inicio AND $pos_fim) {
			$pos_inicio = strpos($conteudo, $tag_inicio) + strlen($tag_inicio);
			$tam = strlen($conteudo) - $pos_fim;
			return substr_replace($conteudo, $conteudo_novo, $pos_inicio, -$tam);
		} else{
			return $conteudo;
		}
	}

	protected function makeRecordFieldsString() {
		$recordFields = "";
		foreach ($this->fields as $field)
		{
			$recordFields .= $field->name.", ";
		}
		$recordFields = substr($recordFields, 0, -2);
		return $recordFields;
	}

	protected function makeRecordAllowedFieldsString() {
		$recordAllowedFields = "";
		$tableConfig = $this->tableConfig;
		foreach ($tableConfig as $field)
		{
			if ($field->allowed) {
				$recordAllowedFields .= "'".$field->name."', ";
			}
		}
		$recordAllowedFields = substr($recordAllowedFields, 0, -2);
		return $recordAllowedFields;
	}

	protected function makeRecordHtmlTableHeader() {
		$tableConfig = $this->tableConfig;

		$tableHeader  = str_repeat("\t", 3).'<thead>'."\r\n";
		$tableHeader .= str_repeat("\t", 4)."<tr>"."\r\n";

		foreach ($tableConfig as $config)
		{
			if ($config->show == 'Y') {
				if ($config->name == 'id') {
					$width = "30";
				} else {
					$width = "";
				}
				$tableHeader .= str_repeat("\t", 5).'<th width="'.$width.'">'.$config->label.'</th>'."\r\n";
			}
		}

		$tableHeader .= str_repeat("\t", 5).'<th width="30">Ações</th>'."\r\n";
		$tableHeader .= str_repeat("\t", 4).'</tr>'."\r\n";
		$tableHeader .= str_repeat("\t", 3)."</thead>"."\r\n";

		return $tableHeader;
	}

	protected function makeRecordFormFields() {
		$table = $this->table;
    $tableConfig = $this->tableConfig;
    $formVisibleFields = $this->formVisibleFields;
    $formVisibleFieldsConfig = $this->formVisibleFieldsConfig;

		$recordFormFields	= "";

		foreach ($formVisibleFieldsConfig as $fieldConfig)
		{
      $recordFormFields .= $this->makeFormField($fieldConfig);
		}

    $recordFormFields .= $this->makeFormFieldSubmit();

    return $recordFormFields;
	}

  protected function makeFormField($fieldConfig) {
    $fieldHtml = '';

    switch ($fieldConfig->type) {
      case "text":
        $fieldHtml = $this->makeFormFieldText($fieldConfig);
        break;
      case "password":
        $fieldHtml = $this->makeFormFieldPassword($fieldConfig);
        break;
      case "textarea":
        $fieldHtml = $this->makeFormFieldTextarea($fieldConfig);
        break;
      case "select":
        $fieldHtml = $this->makeFormFieldSelect($fieldConfig);
        break;
      case "checkbox":
        $fieldHtml = $this->makeFormFieldCheckbox($fieldConfig);
        break;
      case "radio":
        $fieldHtml = $this->makeFormFieldRadio($fieldConfig);
        break;
      case "file":
        $fieldHtml = $this->makeFormFieldFile($fieldConfig);
        break;
      case "hidden":
        $fieldHtml = $this->makeFormFieldHidden($fieldConfig);
        break;
      default:
        $fieldHtml = $this->makeFormFieldText($fieldConfig);
        break;
    }

    return $fieldHtml;
  }

  protected function makeFormFieldText($fieldConfig) {
		$content = file_get_contents($this->crudTemplatesFolder."FormInputText.tpl");
    $newContent = $this->parser->render($content, $fieldConfig);
		return $newContent;
  }

  protected function makeFormFieldPassword($fieldConfig) {
		$content = file_get_contents($this->crudTemplatesFolder."FormInputPassword.tpl");
    $newContent = $this->parser->render($content, $fieldConfig);
		return $newContent;
  }

  protected function makeFormFieldTextarea($fieldConfig) {
		$content = file_get_contents($this->crudTemplatesFolder."FormTextarea.tpl");
    $newContent = $this->parser->render($content, $fieldConfig);
		return $newContent;
  }

  protected function makeFormFieldCheckbox($fieldConfig) {
    if (empty($fieldConfig->options)) {
      if (!empty($fieldConfig->foreign_table_name)) {
        $modelName = ucfirst($fieldConfig->foreign_table_name)."Model";
        $foreignModel = model("App\\Models\\".$modelName);
        $foreignRecords = $foreignModel->findAll();
        foreach ($foreignRecords as $record) {
          $fieldConfig->options[] = ['value' => $record->id, 'text' => $record->name];
        }
      }
    }
		$content = file_get_contents($this->crudTemplatesFolder."FormCheckbox.tpl");
    $newContent = $this->parser->render($content, $fieldConfig);
		return $newContent;
  }

  protected function makeFormFieldRadio($fieldConfig) {
    if (empty($fieldConfig->options)) {
      if (!empty($fieldConfig->foreign_table_name)) {
        $modelName = ucfirst($fieldConfig->foreign_table_name)."Model";
        $foreignModel = model("App\\Models\\".$modelName);
        $foreignRecords = $foreignModel->findAll();
        foreach ($foreignRecords as $record) {
          $fieldConfig->options[] = ['value' => $record->id, 'text' => $record->name];
        }
      }
    }
		$content = file_get_contents($this->crudTemplatesFolder."FormRadio.tpl");
    $newContent = $this->parser->render($content, $fieldConfig);
		return $newContent;
  }

  protected function makeFormFieldSelect($fieldConfig) {
    if (empty($fieldConfig->options)) {
      if (!empty($fieldConfig->foreign_table_name)) {
        $modelName = ucfirst($fieldConfig->foreign_table_name)."Model";
        $foreignModel = model("App\\Models\\".$modelName);
        $foreignRecords = $foreignModel->findAll();
        foreach ($foreignRecords as $record) {
          $fieldConfig->options[] = ['value' => $record->id, 'text' => $record->name];
        }
      }
    }
		$content = file_get_contents($this->crudTemplatesFolder."FormSelect.tpl");
    $newContent = $this->parser->render($content, $fieldConfig);
		return $newContent;
  }

  protected function makeFormFieldFile($fieldConfig) {
		$content = file_get_contents($this->crudTemplatesFolder."FormInputFile.tpl");
    $newContent = $this->parser->render($content, $fieldConfig);
		return $newContent;
  }

  protected function makeFormFieldHidden($fieldConfig) {
		$content = file_get_contents($this->crudTemplatesFolder."FormInputHidden.tpl");
    $newContent = $this->parser->render($content, $fieldConfig);
		return $newContent;
  }

  protected function makeFormFieldSubmit() {
		$content = file_get_contents($this->crudTemplatesFolder."FormSubmitButton.tpl");
    $newContent = $this->parser->render($content, array('label' => 'Salvar'));
		return $newContent;
  }

	protected function setTemplateVars()
	{
		 return array(
			'class_name'												=> ucfirst($this->table),
			'model_name'												=> ucfirst($this->table),
			'controller_name'										=> ucfirst($this->table),
			'view_name'													=> ucfirst($this->table),
			'table'															=> $this->table,
			'table_alias'												=> $this->table,
			'record'														=> $this->table,
			'record_fields'											=> $this->recordFields,
			'record_allowed_fields'							=> $this->recordAllowedFields,
			'page_title_list'										=> ucfirst($this->table).' - Listagem',
			'page_title_view'										=> ucfirst($this->table).' - Visualizar',
			'page_title_new'										=> ucfirst($this->table).' - Novo',
			'page_title_edit'										=> ucfirst($this->table).' - Editar',
			'body_id_list'											=> 'body_'.$this->table.'_list',
			'body_id_view'											=> 'body_'.$this->table.'_view',
			'body_id_novo'											=> 'body_'.$this->table.'_new',
			'body_id_editar'										=> 'body_'.$this->table.'_edit',
			'system_area_title'									=> ucfirst($this->table),
			'system_area_list_description'			=> 'Listagem de registros',
			'system_area_view_description'			=> 'Visualizar registro',
			'system_area_new_description'				=> 'Novo registro',
			'system_area_edit_description'			=> 'Editar registro',
			'table_header'											=> $this->tableHeader,
      'list_header'												=> $this->listVisibleFieldsLabel,
      'list_visible_fields_config'			  => $this->listVisibleFieldsConfig,
			'record_form_fields'								=> $this->recordFormFields
		);
	}

	protected function makeControllerFiles()
	{
		$controllerBaseContent = file_get_contents($this->crudTemplatesFolder."ControllerBase.tpl");
		$controllerContent = file_get_contents($this->crudTemplatesFolder."Controller.tpl");
		$newControllerBaseContent = $this->parse($controllerBaseContent, $this->templateVars);
		$newControllerContent = $this->parse($controllerContent, $this->templateVars);
		$controllerBaseFileName = ucfirst($this->table)."Base.php";
		$controllerFileName = ucfirst($this->table).".php";
		file_put_contents($this->crudControllersBaseFolder.$controllerBaseFileName, $newControllerBaseContent);
		if (!file_exists($this->controllersFolder.$controllerFileName)) {
			file_put_contents($this->controllersFolder.$controllerFileName, $newControllerContent);
		}
	}

	protected function makeModelFiles()
	{
		$entityBaseContent = file_get_contents($this->crudTemplatesFolder."EntityBase.tpl");
		$entityContent = file_get_contents($this->crudTemplatesFolder."Entity.tpl");
		$modelBaseContent = file_get_contents($this->crudTemplatesFolder."ModelBase.tpl");
		$modelContent = file_get_contents($this->crudTemplatesFolder."Model.tpl");
		$newEntityBaseContent = $this->parse($entityBaseContent, $this->templateVars);
		$newEntityContent = $this->parse($entityContent, $this->templateVars);
		$newModelBaseContent = $this->parse($modelBaseContent, $this->templateVars);
		$newModelContent = $this->parse($modelContent, $this->templateVars);
		$entityBaseFileName = ucfirst($this->table)."Base.php";
		$entityFileName = ucfirst($this->table).".php";
		$modelBaseFileName = ucfirst($this->table)."ModelBase.php";
		$modelFileName = ucfirst($this->table)."Model.php";
		file_put_contents($this->crudEntitiesBaseFolder.$entityBaseFileName, $newEntityBaseContent);
		file_put_contents($this->crudModelsBaseFolder.$modelBaseFileName, $newModelBaseContent);
		if (!file_exists($this->entitiesFolder.$entityFileName)) {
			file_put_contents($this->entitiesFolder.$entityFileName, $newEntityContent);
		}
		if (!file_exists($this->modelsFolder.$modelFileName)) {
			file_put_contents($this->modelsFolder.$modelFileName, $newModelContent);
		}
	}

  protected function makeValidationFiles()
	{
		$validationContent = file_get_contents($this->crudTemplatesFolder."Validation.tpl");
    $newValidationContent = $this->parser->render($validationContent, $this->templateVars);
		$validationFileName = ucfirst($this->table)."Validation.php";
    if (!file_exists($this->crudValidationFolder.$validationFileName)) {
		  file_put_contents($this->crudValidationFolder.$validationFileName, $newValidationContent);
    }
	}

  protected function makeViewListFiles()
	{
		$listContent = file_get_contents($this->crudTemplatesFolder."List.tpl");
    $newListContent = $this->parser->render($listContent, $this->templateVars);
		$listFileName = ucfirst($this->table)."List.php";
		file_put_contents($this->viewsFolder.$listFileName, $newListContent);
	}

  protected function makeViewFormFiles()
	{
		$formContent = file_get_contents($this->crudTemplatesFolder."Form.tpl");
    $newFormContent = $this->parser->render($formContent, $this->templateVars);
		$formFileName = ucfirst($this->table)."Form.php";
		file_put_contents($this->viewsFolder.$formFileName, $newFormContent);
	}

	protected function color($text, $color)
	{
		$code_color = "\033[97m";
		$code_color_final = "\033[0m";
		if (strtolower($color) == "red")		{ $code_color = "\033[31m"; }
		if (strtolower($color) == "green")	{ $code_color = "\033[32m"; }
		if (strtolower($color) == "orange")	{ $code_color = "\033[33m"; }
		if (strtolower($color) == "blue")		{ $code_color = "\033[34m"; }
		$text = $code_color.$text.$code_color_final;
		return($text);
	}

	protected function parse($string, $vars) {
		$pattern = array();
		$replacement = array();
		foreach ($vars as $key => $value) {
      if (!is_array($value)) {
        $pattern[] = '/{'.$key.'}/';
        $replacement[] = $value;
      }
		}
		$parsed_string = preg_replace($pattern, $replacement, $string);
		return $parsed_string;
	}

	protected function indent($json) {
    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;

        // If this character is the end of an element,
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }

        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element,
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }

        $prevChar = $char;
    }

    return $result;
	}
}

/* Fim do arquivo Crud.php */
/* Local: ./App/Controllers/Crud.php */
