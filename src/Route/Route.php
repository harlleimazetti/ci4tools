<?php namespace Harlleimazetti\Ci4tools\Route;

use \CodeIgniter\CLI\CLI;
use CodeIgniter\Config\Factories;
use Harlleimazetti\Ci4tools\Crud\Crud;

//defined('DS') or define('DS', DIRECTORY_SEPARATOR);
//defined('VENDOR_NAME') or define('VENDOR_NAME', 'harlleimazetti');
//defined('PACKAGE_NAME') or define('PACKAGE_NAME', 'ci4tools');

class Route extends Crud {
  protected $result = [];
  protected $controllers = [];
  protected $methods = [];
  protected $controller;

	function __construct()
	{
    parent::__construct();

    $this->controllersNotConfigurable = ['BaseController', 'User', 'Group', 'Permission'];

    $this->setControllersConfigurable();
	}

  public function setController($controller = "") {
		if (empty($controller)) {
      throw new \Exception('Controller name can`t be null');
      return null;
		}

    $this->setControllerInfo($controller);
    $this->setControllerConfig($controller);
  }

	protected function setControllerInfo($controller) {
		$this->controller	= $controller;
    $this->methods = $this->controllers->{$controller};
	}

  protected function setControllerConfig($controller) {
    $fileConfigPath = $this->controllerConfigFolder.$controller.".json";

    if (!file_exists($fileConfigPath)) {
      throw new \Exception('Config file not found');
      return null;
    }

    $this->controllerConfig = json_decode(file_get_contents($fileConfigPath));
  }

  protected function setControllersConfigurable() {
    $controllers = (array)$this->controllers;
    $controllersConfigurable = array_diff(array_keys($controllers), $this->controllersNotConfigurable);
    $this->controllersConfigurable  = $controllersConfigurable;
  }

  public function getControllers() {
    return $this->controllers;
  }

  public function getController() {
    return $this->controller;
  }

  public function getMethods() {
    return $this->methods;
  }

  public function getControllerConfig() {
    return $this->controllerConfig;
  }

  public function getControllersNotConfigurable() {
    return $this->controllerNotConfigurable;
  }

  public function getControllersConfigurable() {
    return $this->controllerConfigurable;
  }

	public function controllerinfo($controller = "") {
		if (empty($controller)) {
			CLI::error("CONTROLLERINFO (ERROR): Please, type a controller name.");
			exit;
		}

		$this->setControllerInfo($controller);

    CLI::write("CONTROLLER NAME: ". CLI::color($controller, 'green'), 'white');
    CLI::write("METHODS: ", 'white');
	
    foreach ($this->methods as $method) {
      CLI::write($method->name, 'white');
		}
	}

	public function _create($controller = "") {
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

	public function _make($controllers = "")
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

	public function _config($controllers = "")
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
    
    $this->controllers = [];

    foreach($controllers as $controller)
    {
      $controllerName = substr($controller->getBasename(), 0, -4);
      $this->controllers[$controllerName] = [];

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
  }

	protected function _makeControllerFiles()
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
}

/* Fim do arquivo Route.php */
/* Local: /Harlleimazetti/Ci4tools/Route/Route.php */
