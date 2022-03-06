<?php namespace Harlleimazetti\Ci4tools\Ctrlr;

use \CodeIgniter\CLI\CLI;
use CodeIgniter\Config\Factories;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('VENDOR_NAME') or define('VENDOR_NAME', 'harlleimazetti');
defined('PACKAGE_NAME') or define('PACKAGE_NAME', 'ci4tools');

class Ctrlr {
  protected $result = [];
  protected $controllers = [];

	function __construct()
	{
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

  public function install()
  {

  }

  public function setController($controller = "") {
		if (empty($controller)) {
      throw new \Exception('Controller name can`t be null');
      return null;
		}

    //$this->setControllerInfo($controller);
    $this->setControllerConfig($controller);
  }

	protected function setControllerInfo($controller) {
		$this->controller		  = $controller;
		$this->fields		      = $this->db->getFieldData($this->controller);
		$this->keys			      = $this->db->getForeignKeyData($this->controller);
		$this->indexes        = $this->db->getIndexData($this->controller);
	}

  protected function setControllerConfig($controller) {
    $fileConfigPath = $this->controllerConfigFolder.$controller.".json";

    if (!file_exists($fileConfigPath)) {
      throw new \Exception('Config file not found');
      return null;
    }

    $this->controllerConfig = json_decode(file_get_contents($fileConfigPath));
  }

  public function getControllerConfig() {
    return $this->controllerConfig;
  }

	public function controllerinfo($controller = "") {
		if (empty($controller)) {
			CLI::error("CONTROLLERINFO (ERROR): Please, type a controller name.");
			exit;
		}

		$this->setControllerInfo($controller);

		echo "\r\n";
		echo "> TABLE NAME: ".$this->color($this->controller, "green")."\r\n";
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
					echo $this->color(STR_PAD($this->keys[$k]->foreign_controller_name,20), "green");
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

	public function create($controller = "") {
    $this->result['success'] = true;
        
		if (!empty($controller))
		{
			$this->controller = $controllers;
    }

		$this->setControllerInfo($controller);

    $controllerConfig = [
      "controller"				          => $controller,
      'controllerLabel'						=> ucfirst($this->controller),
      'controllerDescription'			=> ucfirst($this->controller),
      'controllerListTitle'				=> ucfirst($this->controller),
      'controllerFormTitle'				=> ucfirst($this->controller),
      'controllerEditTitle'				=> ucfirst($this->controller).' - Atualizar registro',
      'controllerNewTitle'					=> ucfirst($this->controller).' - Novo registro',
      'controllerViewTitle'				=> ucfirst($this->controller).' - Visualizar registro',
      'controllerListSubtitle'			=> 'Listagem de registros',
      'controllerFormSubtitle'			=> 'Formulário de edição do registro',
      'controllerEditSubtitle'			=> 'Editar registro',
      'controllerNewSubtitle'			=> 'Novo registro',
      'controllerViewSubtitle'			=> 'Detalhes do registro',
      'controllerListDescription'	=> 'Para atualizar ou visualizar os detalhes do registro selecione a opção desejada no menu ao final da linha do registro',
      'controllerFormDescription'	=> 'Os campos com * são obrigatórios',
      'controllerEditDescription'	=> 'Os campos com * são obrigatórios',
      'controllerNewDescription'		=> 'Os campos com * são obrigatórios',
      'controllerViewDescription'  => 'Os campos com * são obrigatórios',
    ];

    $controllerConfig['fields'][] = [
      "controller"				          => $controller,
      "name"				          => $field->name,
      "label"				          => $field->name,
      "nullable"		          => $field->nullable,
      "required"		          => !$field->nullable,
      "default"		            => $field->default,
      "placeholder"           => $field->name,
      "value"                 => '',
      "min"                   => '',
      "max"                   => '',
      "increment"             => '',
      "order"				          => $n,
      "show"				          => $show,
      "show_on_list"          => $show_on_list,
      "show_on_form"          => $show_on_form,
      "type"				          => $type,
      "allowed"			          => $allowed,
      "foreign_controller_name"    => !empty($fk) ? $fk->foreign_controller_name : '',
      "foreign_column_name"   => !empty($fk) ? $fk->foreign_column_name : '',
      "foreign_column_show"   => [],
      "options" 		          => [],
      "relation_type"         => "",
      "multiple"		          => "N",
      "field_class"           => "form-control",
      "label_class"           => "col-sm-2 control-label"
    ];

    //print_r($controllerConfig); exit;

    CLI::write("CREATE (INFO): Creating config file: ". CLI::color($controller.".json", 'green'), 'white');

    $controllerConfig = json_encode($controllerConfig);
    $controllerConfig = $this->indent($controllerConfig);
    $fileConfigPath = $this->crudConfigFolder.$controller.".json";

    if (file_exists($fileConfigPath)) {
      CLI::error("CREATE (ERROR): Config file already exists: ". CLI::color($controller.".json", 'green'));
      $this->result['success'] = false;
      $this->result['messages'][] = 'Config file not created: '.$controller.".json";
      $this->result['errors'][] = 'Config file already exists: '.$controller.".json";
    }

    file_put_contents($fileConfigPath, $controllerConfig);
    CLI::write("CREATE (INFO): Config file successfuly created: ". CLI::color($controller.".json", 'green'), 'white');

    $this->result['messages'][] = 'Config file successfuly created: '.$controller.".json";
    $this->result['errors'] = [];
	
    return (object)$this->result;
	}

	public function make($controllers = "")
	{
    $this->result['success'] = true;

		if (!empty($controllers))
		{
			$pos = strpos($controllers, ",");
			$this->controllers = $pos === false ? array($controllers) : array_map('trim', explode(',', $controllers));
		}

		if (!is_dir($this->crudConfigFolder))
		{
      CLI::error("MAKE (ERROR): CONFIG/CRUD Folder not found: ". CLI::color($this->crudConfigFolder, 'white'));
			exit;
		}

		foreach ($this->controllers as $controller)
		{
      CLI::write(" ");

      try {
        CLI::write("MAKE (INFO): Making CRUD for controller: ". CLI::color($controller, 'green'), 'white');

        CLI::write("MAKE (INFO): Setting controller info", 'white');
        $this->setController($controller);

        CLI::write("MAKE (INFO): Retrieving controller config", 'white');
        $fileConfigPath = $this->crudConfigFolder.$controller.".json";

        CLI::write("MAKE (INFO): Making record fields list", 'white');
        $this->recordFields	= $this->makeRecordFieldsString();

        CLI::write("MAKE (INFO): Making record allowed fields list", 'white');
        $this->recordAllowedFields	= $this->makeRecordAllowedFieldsString();

        CLI::write("MAKE (INFO): Making record controller header", 'white');
        $this->controllerHeader	= $this->makeRecordHtmlControllerHeader();

        CLI::write("MAKE (INFO): Making record HTML form fields", 'white');
        $this->recordFormFields = $this->makeRecordFormFields();

        CLI::write("MAKE (INFO): Setting template vars", 'white');
        $this->templateVars = $this->setTemplateVars();

        CLI::write("MAKE (INFO): Making Controller files", 'white');
        $this->makeControllerFiles();

        CLI::write("MAKE (INFO): Making Validation files", 'white');
        $this->makeValidationFiles();

        CLI::write("MAKE (INFO): Making Model files", 'white');
        $this->makeModelFiles();

        CLI::write("MAKE (INFO): Making View List files", 'white');
        $this->makeViewListFiles();

        CLI::write("MAKE (INFO): Making View Form files", 'white');
        $this->makeViewFormFiles();

      } catch (\Exception $e) {
        CLI::error("MAKE (ERROR): ".$e->getMessage().": ". CLI::color($controller, 'green'));
        
        $this->result['messages'][] = 'MAKE (ERROR): Problems ocurred during CRUD Making of controller: '.$controller;
        $this->result['errors'][] = $e->getMessage().": ".$controller;

        continue;
      }

      CLI::write("MAKE (INFO): End of CRUD Making for controller: ".CLI::color($controller, 'green'), 'white');

      $this->result['messages'][] = 'MAKE (INFO): CRUD successfuly created for controller: '.$controller;
		}

    return (object)$this->result;
	}

	public function config($controllers = "")
  {
		if (!empty($controllers)) {
			$pos = strpos($controllers, ",");
			if ($pos === false) {
				$this->controllers = array($controllers);
			} else {
				$this->controllers = array_map('trim', explode(',', $controllers));
			}
		}

		if (!is_dir($this->crudConfigFolder)) {
      CLI::error("ERROR: CRUD Config folder not found");
			exit;
		}

		foreach ($this->controllers as $controller)
    {
			if (!$this->db->controllerExists($controller)) {
        CLI::error("TABLE CONFIG (ERROR): Controller not found: ". CLI::color($controller, 'green'));
				exit;
			}

      CLI::write("Edit CRUD Config file for controller: ". CLI::color($controller, 'green'), 'white');

      CLI::write("Retrieving controller config");
			$fileConfigPath = $this->crudConfigFolder.$controller.".json";

			if (!file_exists($fileConfigPath)) {
        CLI::error("ERROR: Config file not found: ". CLI::color($controller, 'green'));
				exit;
			}
			
			$this->controllerConfig = json_decode(file_get_contents($fileConfigPath));

      $controllerConfig = json_decode(json_encode($this->controllerConfig), true);
      $controllerFields = array_column($controllerConfig['fields'], 'name');
      $controllerFields = array_diff($controllerFields, $this->fieldsNotConfigurable);

      $selectedField = CLI::promptByKey("Selecione o campo que deseja configurar", $controllerFields);
      
      $configOptions = array_keys($controllerConfig['fields'][$selectedField]);
      $configOptions = array_diff($configOptions, $this->fieldOptionsNotConfigurable);
      
      foreach($configOptions as $i => $option)
      {
        $promptOptions = $controllerConfig['fields'][$selectedField][$option];

        if ($option === 'multiple' || $option === 'show' || $option === 'allowed') {
          $promptOptions = ['Y' => 'Yes', 'N' => 'No'];
          $controllerConfig['fields'][$selectedField][$option] = CLI::promptByKey($option, $promptOptions);
        } else {
          $controllerConfig['fields'][$selectedField][$option] = CLI::prompt($option, $promptOptions);
        }
      }

			$controllerConfig = json_encode($controllerConfig);
			$controllerConfig = $this->indent($controllerConfig);
			$fileConfigPath = $this->crudConfigFolder.$controller.".json";

			file_put_contents($fileConfigPath, $controllerConfig);
    }
	}

  public function saveControllerConfig($controller, $options)
  {
    unset($options['controller']);
    
    $optionsKeys = array_keys($options);
    $countOptions = count($options['name']);

    for ($i = 0; $i < $countOptions; $i++) {
      $newConf[] = array_combine($optionsKeys, array_column($options, $i));
    }
    
    //$controllerFields = $this->crud->getFieldsConfigurable();
    $controllerConfig = $this->getControllerConfig();
    $controllerConfig = json_decode(json_encode($controllerConfig), true);

    foreach($controllerConfig['fields'] as $key => $config) {
      foreach($newConf as $newConfig) {
        if ($config['name'] == $newConfig['name']) {
          $controllerConfig['fields'][$key] = array_merge($config, $newConfig);
        }
      }
    }

    $controllerConfig = json_encode($controllerConfig);
    $controllerConfig = $this->indent($controllerConfig);
    $fileConfigPath = $this->crudConfigFolder.$controller.".json";

    if (!file_put_contents($fileConfigPath, $controllerConfig)) {
      //throw new Exception('Erro ao gravar arquivo de configurção');
      $this->result['success'] = false;
      $this->result['messages'][] = 'Problemas na gravação dos dados';
      $this->result['errors'] = $e->getMessage();
      return (object)$this->result;
    }

    $this->result['success'] = true;
    $this->result['messages'][] = 'Dados salvos com sucesso';
    $this->result['errors'] = [];
    return (object)$this->result;
  }

  public function loadControllers()
  {
    $controllers = new \CodeIgniter\Files\FileCollection;
    $controllers->add($this->controllersFolder, true)->retainPattern('*.php');
    
    foreach($controllers as $controller)
    {
      $controllerName = substr($controller->getBasename(), 0, -4);
      $this->controllers[$controllerName] = [];

      //print_r($this->controllers);

      $instance = Factories::controllers($controllerName);
      $class    = new \ReflectionClass($instance);
      $methods  = $class->getMethods(\ReflectionMethod::IS_PUBLIC);

      foreach($methods as $method)
      {
        $m = (stristr($method->class, $controllerName) && $method->name !== '__construct') ? $method : null;
        !empty($m) && array_push($this->controllers[$controllerName], $m);
      }
    }

    $this->controllers = (object)$this->controllers;

    foreach($this->controllers as $controller => $methods) {
      echo $controller."\r\n";
      foreach ($methods as $method) {
        echo "  :.....".$method->name."\r\n";
      }
    }
    //print_r((object)$this->controllers);
  }

	protected function loadVisibleFields($controller = "")
  {
		if (empty($controller)) {
      return null;
		}

		if (!is_dir($this->crudConfigFolder)) {
      //CLI::error("ERROR: CRUD Config folder not found");
			return null;
		}

    if (!$this->db->controllerExists($controller)) {
      //CLI::error("TABLE CONFIG (ERROR): Controller not found: ". CLI::color($controller, 'green'));
      return null;
    }

    $fileConfigPath = $this->crudConfigFolder.$controller.".json";

    if (!file_exists($fileConfigPath)) {
      //CLI::error("ERROR: Config file not found: ". CLI::color($controller, 'green'));
      return null;
    }
    
    $this->controllerConfig = json_decode(file_get_contents($fileConfigPath));

    $controllerConfig = json_decode(json_encode($this->controllerConfig), true);

    /* Find fields that area displayable: show = Y */
    $displayableFields = array_keys(array_column($controllerConfig['fields'], 'show'), 'Y');

    /* Intersect displyable fields to filter $controllerConfig array */
    $b = array_intersect_key($controllerConfig['fields'], array_flip($displayableFields));

    /* Retrieve array with fields names and filter for return only configurable fields */
    $controllerFields  = array_column($b, 'name');
    $controllerFields  = array_diff($controllerFields, $this->fieldsNotConfigurable);

    return $controllerFields;
	}

  protected function loadListVisibleFieldsConfig($controller = "") {
		if (empty($controller)) {
      return null;
		}

    $controllerConfig = json_decode(json_encode($this->controllerConfig), true);

    if (empty($controllerConfig)) {
      return null;
    }

    /* Find fields that area displayable: show = Y */
    $displayableFields = array_keys(array_column($controllerConfig['fields'], 'show'), 'Y');

    /* Intersect displyable fields to filter $this->controllerConfig array */
    $listVisibleFieldsConfig = array_intersect_key($controllerConfig['fields'], array_flip($displayableFields));

    return $listVisibleFieldsConfig;
  }

  protected function loadFormVisibleFieldsConfig($controller = "") {
		if (empty($controller)) {
      return null;
		}

    $controllerConfig = json_decode(json_encode($this->controllerConfig), true);

    if (empty($controllerConfig)) {
      return null;
    }

    /* Find fields that area displayable: show_on_form = Y */
    $displayableFields = array_keys(array_column($controllerConfig['fields'], 'show_on_form'), 'Y');

    /* Intersect displyable fields to filter $this->controllerConfig array */
    $formVisibleFieldsConfig = array_intersect_key($controllerConfig['fields'], array_flip($displayableFields));

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
		$controllerConfig = $this->controllerConfig;
		foreach ($controllerConfig->fields as $field)
		{
			if ($field->allowed) {
				$recordAllowedFields .= "'".$field->name."', ";
			}
		}
		$recordAllowedFields = substr($recordAllowedFields, 0, -2);
		return $recordAllowedFields;
	}

	protected function makeRecordHtmlControllerHeader() {
		$controllerConfig = $this->controllerConfig;

		$controllerHeader  = str_repeat("\t", 3).'<thead>'."\r\n";
		$controllerHeader .= str_repeat("\t", 4)."<tr>"."\r\n";

		foreach ($controllerConfig->fields as $config)
		{
			if ($config->show == 'Y') {
				if ($config->name == 'id') {
					$width = "30";
				} else {
					$width = "";
				}
				$controllerHeader .= str_repeat("\t", 5).'<th width="'.$width.'">'.$config->label.'</th>'."\r\n";
			}
		}

		$controllerHeader .= str_repeat("\t", 5).'<th width="30">Ações</th>'."\r\n";
		$controllerHeader .= str_repeat("\t", 4).'</tr>'."\r\n";
		$controllerHeader .= str_repeat("\t", 3)."</thead>"."\r\n";

		return $controllerHeader;
	}

	protected function makeRecordFormFields() {
		$controller = $this->controller;
    $controllerConfig = $this->controllerConfig;
    $formVisibleFields = $this->formVisibleFields;
    $formVisibleFieldsConfig = $this->formVisibleFieldsConfig;

		$recordFormFields	= "";

		foreach ($formVisibleFieldsConfig as $fieldConfig)
		{
      $recordFormFields .= $this->makeFormField((object)$fieldConfig);
		}

    $recordFormFields .= $this->makeFormBack();
    $recordFormFields .= $this->makeFormSubmit();

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
      if (!empty($fieldConfig->foreign_controller_name)) {
        $modelName = ucfirst($fieldConfig->foreign_controller_name)."Model";
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
      if (!empty($fieldConfig->foreign_controller_name)) {
        $modelName = ucfirst($fieldConfig->foreign_controller_name)."Model";
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
      if (!empty($fieldConfig->foreign_controller_name)) {
        $modelName = ucfirst($fieldConfig->foreign_controller_name)."Model";
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

  protected function makeFormSubmit() {
		$content = file_get_contents($this->crudTemplatesFolder."FormSubmitButton.tpl");
    $newContent = $this->parser->render($content, array('label' => 'Salvar'));
		return $newContent;
  }

  protected function makeFormBack() {
		$content = file_get_contents($this->crudTemplatesFolder."FormBackButton.tpl");
    $newContent = $this->parser->render($content, array('label' => 'Voltar'));
		return $newContent;
  }

	protected function setTemplateVars()
	{
		 return array(
			'class_name'												=> ucfirst($this->controller),
			'model_name'												=> ucfirst($this->controller),
			'controller_name'										=> ucfirst($this->controller),
			'view_name'													=> ucfirst($this->controller),
			'controller'															=> $this->controller,
			'controller_alias'												=> $this->controller,
			'record'														=> $this->controller,
			'record_fields'											=> $this->recordFields,
			'record_allowed_fields'							=> $this->recordAllowedFields,
			'page_title_list'										=> ucfirst($this->controller).' - Listagem',
			'page_title_view'										=> ucfirst($this->controller).' - Visualizar',
			'page_title_new'										=> ucfirst($this->controller).' - Novo',
			'page_title_edit'										=> ucfirst($this->controller).' - Editar',
			'body_id_list'											=> 'body_'.$this->controller.'_list',
			'body_id_view'											=> 'body_'.$this->controller.'_view',
			'body_id_novo'											=> 'body_'.$this->controller.'_new',
			'body_id_editar'										=> 'body_'.$this->controller.'_edit',
			'system_area_title'									=> ucfirst($this->controller),
			'system_area_list_description'			=> 'Listagem de registros',
			'system_area_view_description'			=> 'Visualizar registro',
			'system_area_new_description'				=> 'Novo registro',
			'system_area_edit_description'			=> 'Editar registro',
			'controller_header'											=> $this->controllerHeader,
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
		$controllerBaseFileName = ucfirst($this->controller)."Base.php";
		$controllerFileName = ucfirst($this->controller).".php";
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
		$entityBaseFileName = ucfirst($this->controller)."Base.php";
		$entityFileName = ucfirst($this->controller).".php";
		$modelBaseFileName = ucfirst($this->controller)."ModelBase.php";
		$modelFileName = ucfirst($this->controller)."Model.php";
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
		$validationFileName = ucfirst($this->controller)."Validation.php";
    if (!file_exists($this->crudValidationFolder.$validationFileName)) {
		  file_put_contents($this->crudValidationFolder.$validationFileName, $newValidationContent);
    }
	}

  protected function makeViewListFiles()
	{
		$listContent = file_get_contents($this->crudTemplatesFolder."List.tpl");
    $newListContent = $this->parser->render($listContent, $this->templateVars);
		$listFileName = ucfirst($this->controller)."List.php";
		file_put_contents($this->viewsFolder.$listFileName, $newListContent);
	}

  protected function makeViewFormFiles()
	{
		$formContent = file_get_contents($this->crudTemplatesFolder."Form.tpl");
    $newFormContent = $this->parser->render($formContent, $this->templateVars);
		$formFileName = ucfirst($this->controller)."Form.php";
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
