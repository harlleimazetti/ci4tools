<?php namespace Harlleimazetti\Ci4tools\Crud;

use CodeIgniter\CLI\CLI;

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
	protected $recordFields;
	protected $recordAllowedFields;
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
  protected $crudConfigFolder;
	protected $crudTemplatesFolder;
  protected $fieldsNotConfigurable;
  protected $fieldOptionsNotConfigurable;

	function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->tables = $this->db->listTables();

    $this->vendorFolder 						  = ROOTPATH."vendor".DS.VENDOR_NAME.DS.PACKAGE_NAME.DS."src".DS;

    $this->moduleFolder 						  = ROOTPATH."ci4toolsadmin".DS;

		$this->crudTemplatesFolder 				= ROOTPATH."vendor".DS.VENDOR_NAME.DS.PACKAGE_NAME.DS."src".DS."Crud".DS."templates".DS;
		
    $this->crudBaseFolder 						= $this->moduleFolder."Crudbase".DS;

		$this->crudConfigFolder 					= $this->crudBaseFolder."Config".DS;
		$this->crudControllersBaseFolder 	= $this->crudBaseFolder."Controllers".DS;
    $this->crudModelsBaseFolder 			= $this->crudBaseFolder."Models".DS;
		$this->crudEntitiesBaseFolder 		= $this->crudBaseFolder."Entities".DS;

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

    $source = $this->vendorFolder."Module";
    $sourceAssets = $this->vendorFolder."Module".DS."public";
    $destinationModule = $this->moduleFolder;
    $destinationAssets = FCPATH;

    $publisher = new \CodeIgniter\Publisher\Publisher($source, $destinationModule);

    $publisher->addPath('Controllers');
    $publisher->addPath('Entities');
    $publisher->addPath('Models');
    $publisher->addPath('Views');

    $publisher->merge(false);

    $publisherAssets = new \CodeIgniter\Publisher\Publisher($sourceAssets, $destinationAssets);
    
    $publisherAssets->addPath('ci4toolsadmin');
    
    $publisherAssets->merge(false);
  }

	protected function setTableInfo($table) {
		$this->table		= $table;
		$this->fields		= $this->db->getFieldData($this->table);
		$this->keys			= $this->db->getForeignKeyData($this->table);
		$this->indexes	= $this->db->getIndexData($this->table);
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

			foreach ($this->fields as $field)
			{
				$type			= "text";
				$show			= "Y";
				$allowed	= 1;

				if ($field->name == "id") {
					$type			= "hidden";
					$show			= "Y";
					$allowed	= 0;
				}

				if ($field->name == "created_at" || $field->name == "updated_at" || $field->name == "deleted_at") {
					$type			= "hidden";
					$show			= "N";
					$allowed	= 0;
				}

				if ($field->name == "password") {
					$type			= "hidden";
					$show			= "N";
					$allowed	= 0;
				}

				$tableConfig[] = array(
					"name"				=> $field->name,
					"label"				=> $field->name,
					"order"				=> $n,
					"show"				=> $show,
					"type"				=> $type,
					"allowed"			=> $allowed,
					"multiple"		=> "N",
					"field_class"	=> "form-control",
					"label_class"	=> "col-sm-2 control-label"
				);
				$n++;
			}

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
		//exit;
		//$dir = FCPATH.'assets/tpl';
		//$arquivos = scandir($dir);
		//print_r($arquivos);

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
			$this->tableConfig = file_get_contents($fileConfigPath);

			//$relation = json_decode($table_def->relation);

			echo "Making record fields list"."\r\n";
			$this->recordFields	= $this->makeRecordFieldsString();

			echo "Making record allowed fields list"."\r\n";
			$this->recordAllowedFields	= $this->makeRecordAllowedFieldsString();

			echo "Making record table header"."\r\n";
			$this->tableHeader	= $this->makeRecordHtmlTableHeader($this->tableConfig);

			echo "Setting template vars"."\r\n";
			$this->templateVars = $this->setTemplateVars();
			//$this->makeRecordHtmlForm($tableConfig);

			echo "Making controller files"."\r\n";
			$this->makeControllerFiles();

			echo "Making model files"."\r\n";
			$this->makeModelFiles();

			echo "Making View List files"."\r\n";
			$this->makeViewListFiles();

			echo "End of table config"."\r\n";
			echo ".:."."\r\n";
			//exit;

			/*
			$arquivo = FCPATH.'assets/tpl/control.tpl';
			$arq = fopen($arquivo, 'r');
			$conteudo_control = fread($arq, filesize($arquivo));
			fclose($arq);

			$arquivo = FCPATH.'assets/tpl/model.tpl';
			$arq = fopen($arquivo, 'r');
			$conteudo_model = fread($arq, filesize($arquivo));
			fclose($arq);

			$arquivo = FCPATH.'assets/tpl/list.tpl';
			$arq = fopen($arquivo, 'r');
			$conteudo_list = fread($arq, filesize($arquivo));
			fclose($arq);

			$arquivo = FCPATH.'assets/tpl/form.tpl';
			$arq = fopen($arquivo, 'r');
			$conteudo_form = fread($arq, filesize($arquivo));
			fclose($arq);

			$arquivo = FCPATH.'assets/tpl/view.tpl';
			$arq = fopen($arquivo, 'r');
			$conteudo_view = fread($arq, filesize($arquivo));
			fclose($arq);

			$arquivo = FCPATH.'assets/tpl/lang.tpl';
			$arq = fopen($arquivo, 'r');
			$conteudo_lang = fread($arq, filesize($arquivo));
			fclose($arq);

			foreach ($vars as $k => $v)
			{
				$str_search = '{{'.$k.'}}';
				$conteudo_control = str_replace($str_search, $v, $conteudo_control);
				$conteudo_model = str_replace($str_search, $v, $conteudo_model);
				$conteudo_list = str_replace($str_search, $v, $conteudo_list);
				$conteudo_form = str_replace($str_search, $v, $conteudo_form);
				$conteudo_view = str_replace($str_search, $v, $conteudo_view);
				$conteudo_lang = str_replace($str_search, $v, $conteudo_lang);
			}

			$arquivo = APPPATH."controllers/".ucfirst($table).".php";
			$this->grava_arquivo($arquivo, $conteudo_control);

			$arquivo = APPPATH.'models/'.ucfirst($table).'_model.php';
			$this->grava_arquivo($arquivo, $conteudo_model);

			$arquivo = APPPATH.'views/'.ucfirst($table).'_lista.php';
			$this->grava_arquivo($arquivo, $conteudo_list);

			$arquivo = APPPATH.'views/'.ucfirst($table).'_form.php';
			$this->grava_arquivo($arquivo, $conteudo_form);

			$arquivo = APPPATH.'views/'.ucfirst($table).'_ver.php';
			$this->grava_arquivo($arquivo, $conteudo_view);
			*/
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
			
			$this->tableConfig = file_get_contents($fileConfigPath);

      $tableConfig   = json_decode($this->tableConfig, true);
      $tableFields  = array_column($tableConfig, 'name');
      $tableFields  = array_diff($tableFields, $this->fieldsNotConfigurable);

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

	public function getVisibleFields($tables = "")
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

			$fileConfigPath = $this->crudConfigFolder.$table.".json";

			if (!file_exists($fileConfigPath)) {
        CLI::error("ERROR: Config file not found: ". CLI::color($table, 'green'));
				exit;
			}
			
			$this->tableConfig = file_get_contents($fileConfigPath);

      $tableConfig   = json_decode($this->tableConfig, true);

      /* Find fields that area displayable: show = Y */
      $displayableFields = array_keys(array_column($tableConfig, 'show'), 'Y');

      /* Intersect displyable fields to filter $tableConfig array */
      $b = array_intersect_key($tableConfig, array_flip($displayableFields));

      /* Retrieve array with fields names and filter for return only configurable fields */
      $tableFields  = array_column($b, 'name');
      $tableFields  = array_diff($tableFields, $this->fieldsNotConfigurable);
  
      return $tableFields;
    }
	}

	protected function grava_arquivo($arquivo, $conteudo) {
		if (file_exists($arquivo)) {
			$fp = fopen($arquivo, 'rb');
			$conteudo_arquivo = fread($fp, filesize($arquivo));
			$conteudo_arquivo_extraido = $this->extrair_conteudo($conteudo_arquivo, '//<<inicio>>', '//<<fim>>');
			fclose($fp);
			if ($conteudo_arquivo_extraido) {
				$conteudo = $this->inserir_conteudo($conteudo, $conteudo_arquivo_extraido, '//<<inicio>>', '//<<fim>>');
			} else {
				$conteudo = $conteudo_arquivo;
			}
		}
		$fp = fopen($arquivo, 'wb');
		fwrite($fp, $conteudo);
		fclose($fp);
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
		$tableConfig = json_decode($this->tableConfig);
		foreach ($tableConfig as $field)
		{
			if ($field->allowed) {
				$recordAllowedFields .= "'".$field->name."', ";
			}
		}
		$recordAllowedFields = substr($recordAllowedFields, 0, -2);
		return $recordAllowedFields;
	}

	protected function makeRecordHtmlTableHeader($tableConfig) {
		$tableConfig = json_decode($tableConfig);

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

	protected function makeRecordHtmlForm($tableConfig) {
		$tableConfig = json_decode($tableConfig);

		$formFields		= "";

		foreach ($tableConfig as $config)
		{
			if ($config->type =='hidden') {
			  $type = 'hidden';
			  $label = '';
			} else {
			  $type = 'text';
			  $label = $config->label;
			}

			if ($config->form_tipo_campo == 'checkbox') {
			  $formFields .= custom_form_checkbox($table, $config);
			} else if ($config->form_tipo_campo == 'text') {
			  $formFields .= custom_form_text($table, $config);
			} else if ($config->form_tipo_campo == 'hidden') {
			  $formFields .= custom_form_hidden($table, $config);
			} else if ($config->form_tipo_campo == 'password') {
			  $formFields .= custom_form_password($table, $config);
			} else if ($config->form_tipo_campo == 'select') {
			  $formFields .= custom_form_select($table, $config, $relation);
			} else if ($config->form_tipo_campo == 'file') {
			  $formFields .= custom_form_file($table, $config);
			} else {
			  $formFields .= custom_form_text($table, $config);
			}

		}

		$campos_form .= str_repeat("\t", 8).'<div class="form-group">'."\r\n";
		$campos_form .= str_repeat("\t", 9).'<label class="col-md-3 control-label"></label>'."\r\n";
		$campos_form .= str_repeat("\t", 9).'<div class="col-md-9">'."\r\n";
		$campos_form .= str_repeat("\t", 10).'<button type="submit" class="btn btn-sm btn-success">Salvar</button> <a href="<?php echo base_url() ?>'.$table.'"><button type="button" class="btn btn-sm btn-warning">Voltar</button></a>'."\r\n";
		$campos_form .= str_repeat("\t", 9).'</div>'."\r\n";
		$campos_form .= str_repeat("\t", 8).'</div>'."\r\n";
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
			'form_fields'												=> $this->formFields
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

  protected function makeViewListFiles()
	{
		$listContent = file_get_contents($this->crudTemplatesFolder."list.tpl");
		$newListContent = $this->parse($listContent, $this->templateVars);
		$listFileName = ucfirst($this->table)."List.php";
		file_put_contents($this->viewsFolder.$listFileName, $newListContent);
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
			$pattern[] = '/{'.$key.'}/';
			$replacement[] = $value;
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
