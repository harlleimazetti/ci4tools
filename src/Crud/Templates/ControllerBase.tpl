<?php namespace App\CrudBase\Controllers;

use App\Controllers\BaseController;

class {class_name}Base extends BaseController {
	private $result;
	private $relations;
	private $data = array();

	function __construct()
	{
		$this->result['message'] = array();
		/*
		if(!$this->session->userdata('logado'))
		{
			redirect('login');
		}
		*/

		//$this->lang->load("Header", $this->session->userdata('system_user_site_lang'));
		//$this->lang->load("Sidebar", $this->session->userdata('system_user_site_lang'));
		//$this->lang->load("{classe_nome}", $this->session->userdata('system_user_site_lang'));

		//$this->load->helper('util');

		/*
		$this->load->model('table_def_model');
		$table_def = $this->table_def_model->get_table_def(array('AND' => array('tabela' => '{table}')));
		$table_def = reset($table_def);
		if (!empty($table_def->relation)) {
		$relations = json_decode($table_def->relation);
			foreach ($relations as $relation) {
				$model_name = $relation->table2.'_model';
				$table_name = $relation->table2;
				$this->load->model($model_name);
				${$table_name."s"} = $this->{$model_name}->get_all();
				if (!isset($this->data[$table_name."s"])) {
					$this->data[$table_name."s"] = ${$table_name."s"};
				}
			}
		}
		*/
	}

	public function index()
	{
		redirect('{table}/list');
	}

	public function search()
	{
		${table}Model = new \App\Models\{model_name}Model();
		${record}s = ${table}Model->get{model_name}(array('AND' => array('{table_alias}.NO_PROCEDIMENTO' => $this->request->getPost('search'))));
		echo json_encode(${record}s);
	}

	public function list()
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		//${record}s = ${table}Model->getAll(array());
		$this->data['page_title'] = '{page_title_list}';
		$this->data['pages'][] = '{view_name}List';
		$this->data['data'] = array();
		$this->data['body_id'] = '{body_id_list}';
		$this->data['system_area_title'] = '{system_area_title}';
		$this->data['system_area_description'] = '{system_area_list_description}';
		//$this->data['{record}s'] = ${record}s;
		echo $this->loadTemplate($this->data['pages'], $this->data);
	}

	function list_datatables_columns()
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		$colunas = ${table}Model->getDatatablesColumns();
		echo json_encode($colunas);
	}

	function list_datatables($params = array())
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		if (empty($params)) {
			$params = (array)json_decode($this->request->getPost('params'));
			if (empty($params)) {
				$params = array();
			}
		}
		${table}Model = new \App\Models\{model_name}Model();
		${record}s = ${table}Model->getDatatablesRecords(array('AND' => $params));
		echo ${record}s;
	}

	public function view($id)
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		${record} = ${table}Model->get{model_name}(array('AND' => array('{table_alias}.id' => $id)));
		$this->data['page_title'] = '{page_title_view}';
		//$this->data['title_page'] = lang('title_page_view');
		$this->data['pages'][] = '{view_name}_ver';
		$this->data['data'] = array();
		$this->data['body_id'] = '{body_id_view}';
		$this->data['system_area_title'] = '{system_area_title}';
		$this->data['system_area_description'] = '{system_area_view_description}';
		$this->data['{record}'] = ${record};
		if (file_exists(APPPATH."Views/{class_name}ViewDetails.php")) {
			$this->data['pages'][] = '{class_name}ViewDetails';
		}
		echo $this->loadTemplate($this->data['pages'], $this->data);
	}

	public function new()
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		${record} = ${table}Model->get{model_name}(array('AND' => array('{table_alias}.id' => 0)));
		$this->data['page_title'] = '{page_title_new}';
		//$this->data['title_page'] = lang('page_title_new');
		$this->data['pages'][] = '{view_name}Form';
		$this->data['data'] = array();
		$this->data['body_id'] = '{body_id_new}';
		$this->data['system_area_title'] = '{system_area_title}';
		$this->data['system_area_description'] = '{system_area_new_description}';
		$this->data['{record}'] = ${record};
		$this->data['operacao_bd'] = 'new';
		$this->data['acao'] = 'new';
		echo $this->loadTemplate($this->data['pages'], $this->data);
	}

	public function edit($id)
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		${record} = ${table}Model->get{model_name}(array('AND' => array('{table_alias}.id' => $id)));
		$this->data['page_title'] = '{page_title_edit}';
		//$this->data['title_page'] = lang('page_title_edit');
		$this->data['pages'][] = '{view_name}Form';
		$this->data['data'] = array();
		$this->data['body_id'] = '{body_id_editar}';
		$this->data['system_area_title'] = '{system_area_title}';
		$this->data['system_area_description'] = '{system_area_edit_description}';
		$this->data['{record}'] = ${record};
		$this->data['operacao_bd'] = 'edit';
		$this->data['acao'] = 'edit';
		echo $this->loadTemplate($this->data['pages'], $this->data);
	}

	public function load()
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		${record} = ${table}Model->get{model_name}(array('AND' => array('{table_alias}.id' => $this->request->getPost('id'))));
		if (empty(${record})) {
			$this->result['status'] = "er";
			$this->result['message'][] = 'Não foi possível carregar o registro';
		} else {
			${record} = reset(${record});
			$this->result['status'] = "ok";
			$this->result['message'][] = 'Registro carregado com sucesso';
			$this->result['record'] = ${record};
		}
		echo json_encode($this->result);
	}

	public function load_list()
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		${record} = ${table}Model->get{model_name}(array('LIKE' => array($this->request->getPost('field_name') => $this->request->getPost('q'))));
		echo json_encode(${record});
	}

	public function load_page($page = 0, $per_page = 20, $q = '', $params = array(), $template = '')
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));

		if (!isset($params)) {
			$params	= array();
		}

		if ($this->request->getPost('params')) {
			$params['AND'] = $this->request->getPost('params');
		}

		//$params['FILTRAR_REGISTROS_USUARIO'] 	= $permissao_params['FILTRAR_REGISTROS_USUARIO'];
		//$params['FILTRAR_NIVEL_USUARIO'] 			= $permissao_params['FILTRAR_NIVEL_USUARIO'];
		//$params['USUARIO_NIVEL_PERMITIDO'] 		= $permissao_params['USUARIO_NIVEL_PERMITIDO'];

		${table}Model = new \App\Models\{model_name}Model();

		$page			= $this->request->getPost('page');
		$per_page	= $this->request->getPost('per_page');
		$q 				= $this->request->getPost('q');
		$template = $this->request->getPost('template');

		$like = array();
		if (!empty($q)) {
			$fields = ${table}Model->getFields();
			foreach($fields as $field => $val) {
				$like[$field] = $q;
			}
		}

		$params['OR_LIKE']	= $like;
		$params['LIMIT']		= array('page' => $page, 'per_page' => $per_page);

		${record}s = ${table}Model->get{class_name}($params);

		$this->result['params']['page']			= $page;
		$this->result['params']['per_page']	= $per_page;
		$this->result['data'] = ${record}s;

		if (!empty($template)) {
			$parser = \Config\Services::parser();
			$parser->setData($this->result)->render($template);
		} else {
			echo json_encode($this->result);
		}
	}

	public function erase()
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		$this->result = ${table}Model->erase($this->request->getPost('id'));
		echo json_encode($this->result);
	}

	public function store()
	{
		$this->permissao->resultado($this->permissao->verifica($this->router->class, $this->router->method));
		${table}Model = new \App\Models\{model_name}Model();
		$this->result = ${table}Model->store($this->request->getPost());
		echo json_encode($this->result);
	}
}

/* End of File {class_name}Base.php */
/* Path: ./app/Controllers/CrudBase/{class_name}Base.php */
