<?php namespace App\Crudbase\Controllers;

use App\Crudbase\Controllers\MainController;
use \Harlleimazetti\Ci4tools\Crud\Crud;
use \Hermawan\DataTables\DataTable;

class {class_name}Base extends MainController
{
	private $result;
  private $crud;
	private $relations;
  private $visibleFields;
  private $listVisibleFields;
  private $formVisibleFields;
  private $searchableFields;
	private $data = [];

	function __construct()
	{
    $this->result = new \stdClass();
    $this->crud = new Crud();
    $this->crud->setTable('{table}');

    $this->visibleFields      = $this->crud->getVisibleFields();
    $this->listVisibleFields  = $this->crud->getListVisibleFields();
    $this->formVisibleFields  = $this->crud->getFormVisibleFields();
    $this->searchableFields   = $this->crud->getSearchableFields();
	}

	public function index()
	{
		return redirect('{table}/list');
	}

	public function list()
	{
		${table}Model = new \App\Models\{model_name}Model();
    $this->data['data'] = array();
		${record}s = ${table}Model->withTenant($this->tenant)->findAll();
    
    $this->data['{record}s']          = ${record}s;
    $this->data['listVisibleFields']  = $this->listVisibleFields;
    $this->data['page_title']         = 'Lista';
    $this->data['page_subtitle']      = 'Listagem de registros';
    $this->data['page_description']   = '{system_area_list_description}';
    $this->data['page_icon']          = 'fal fa-globe';
    $this->data['body_id']            = 'body_{table}_list';
    $this->data['system_area']        = '{system_area_list_description}';
    $this->data['menus']              = $this->menus;

    $this->data['theme_options']      = [
      'show_header' => true,
      'show_nav_side' => true,
      'show_nav_top' => true,
      'show_footer' => true,
    ];

    $contents = array('{view_name}List');

    echo $this->showView(
      $theme_name     = $this->config->themeName,
      $theme_options  = $this->data['theme_options'],
      $contents       = $contents,
      $data           = $this->data,
    );
	}

  public function new()
  {
		${table}Model = new \App\Models\{model_name}Model();
    ${record} = array(new \App\Entities\{model_name}());
    
    $this->data['data']               = array();
    $this->data['{record}']           = ${record};
    $this->data['formVisibleFields']  = $this->formVisibleFields;
    $this->data['page_title']         = 'Novo registro';
    $this->data['page_subtitle']      = 'Preencha o formulário abaixo';
    $this->data['page_description']   = '{system_area_new_description}';
    $this->data['page_icon']          = 'fal fa-globe';
    $this->data['body_id']            = 'body_place_new';
    $this->data['system_area']        = '{system_area_new_description}';
    $this->data['menus']              = $this->menus;

    $this->data['theme_options']      = [
      'show_header' => true,
      'show_nav_side' => true,
      'show_nav_top' => true,
      'show_footer' => true,
    ];

    $contents = array('{view_name}Form');

    echo $this->showView(
      $theme_name     = $this->config->themeName,
      $theme_options  = $this->data['theme_options'],
      $contents       = $contents,
      $data           = $this->data,
    );
  }

  public function edit($id)
  {
		${table}Model = new \App\Models\{model_name}Model();
    ${record} = ${table}Model->withTenant($this->tenant)->where('id', $id)->findAll();
    
    $this->data['data']               = array();
    $this->data['{record}']           = ${record};
    $this->data['formVisibleFields']  = $this->formVisibleFields;
    $this->data['page_title']         = 'Editar registro';
    $this->data['page_subtitle']      = 'Preencha o formulário abaixo';
    $this->data['page_description']   = '{system_area_edit_description}';
    $this->data['page_icon']          = 'fal fa-globe';
    $this->data['body_id']            = 'body_place_new';
    $this->data['system_area']        = '{system_area_edit_description}';
    $this->data['menus']              = $this->menus;

    $this->data['theme_options']      = [
      'show_header' => true,
      'show_nav_side' => true,
      'show_nav_top' => true,
      'show_footer' => true,
    ];

    $contents = array('{view_name}Form');

    echo $this->showView(
      $theme_name     = $this->config->themeName,
      $theme_options  = $this->data['theme_options'],
      $contents       = $contents,
      $data           = $this->data,
    );
  }

  public function erase()
	{
		${table}Model = new \App\Models\{model_name}Model();
		$this->result = ${table}Model->erase($this->request->getPost('id'));
		echo json_encode($this->result);
	}

	public function store()
	{
		${table}Model = new \App\Models\{model_name}Model();
		$this->result = ${table}Model->store($this->request->getPost());
    if ($this->result->success === false) {
       return $this->fail($this->result, 400);
    }

		return $this->respond($this->result, 200);
	}

  private function executeSearch($q = '', $page = 0, $perPage = 20, $params = [], $source = '', $template = '')
  {
    $q        = empty($q)         ? $this->request->getPostGet('q')         : $q;
    $page     = empty($page)      ? $this->request->getPostGet('page')      : $page;
    $perPage  = empty($perPage)   ? $this->request->getPostGet('perPage')   : $perPage;
    $params   = empty($params)    ? $this->request->getPostGet('params')    : $params;
    $source   = empty($source)    ? $this->request->getPostGet('source')    : $source;
    $template = empty($template)  ? $this->request->getPostGet('template')  : $template;

    $columns = implode(', ', $this->listVisibleFields);

		${table}Model = new \App\Models\{model_name}Model();

		${table}Model->select($columns);
    ${table}Model->withTenant($this->tenant);
    
    if (!empty($q)) {
      ${table}Model->groupStart();
      foreach($this->searchableFields as $field) {
        ${table}Model->orLike($field, $q);
      }
      ${table}Model->groupEnd();
    }
  
    ${table}Model->limit($perPage, ($page * $perPage));

    return ${table}Model;
  }

  public function search($q = '', $page = 0, $perPage = 20, $params = [], $source = '', $template = '')
	{
    $q        = empty($q)         ? $this->request->getPostGet('q')         : $q;
    $page     = empty($page)      ? $this->request->getPostGet('page')      : $page;
    $perPage  = empty($perPage)   ? $this->request->getPostGet('perPage')   : $perPage;
    $params   = empty($params)    ? $this->request->getPostGet('params')    : $params;
    $source   = empty($source)    ? $this->request->getPostGet('source')    : $source;
    $template = empty($template)  ? $this->request->getPostGet('template')  : $template;

    $searchResult = $this->executeSearch($this->request->getPost('q'));
    ${record}s = $searchResult->get();

		return json_encode(${record}s->getResult());
	}

  public function searchSelect2() {
    $searchResult = $this->executeSearch($this->request->getPost('q'));
    ${record}s = $searchResult->get();

    $response = [
      'results'     => [],
      'pagination'  => false
    ];

    foreach(${record}s->getResult() as $data) {
      $response['results'][] = [
        'id'    => $data->id,
        'text'  => $data->nome
      ];
    }

    return json_encode($response);
  }

  public function searchDataTables() {
    $searchResult = $this->executeSearch($this->request->getPost('q'));
    return DataTable::of($searchResult->builder())
      ->edit('id', function($row){
        return 
        '<td class="text-center">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="id[]" id="id['.$row->id.']" value="'.$row->id.'">
              <label class="custom-control-label" for="id['.$row->id.']"></label>
            </div>
          </td>';
      })
      ->add('actions', function($row) {
        return
        '<td class="text-center">
            <div class="btn-group dropleft">
              <button type="button" class="btn btn-outline btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fal fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="'.base_url('/sistema/{table}/edit').'/'.$row->id.'"><i class="fal fa-edit mr-2"></i> Editar</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0)"><i class="fal fa-times-circle mr-2"></i> Excluir</a>
              </div>
            </div>
          </td>';
      })
      ->toJson(true);
  }

	function dataTablesColumns()
	{
    $columns = [];
    
    foreach ($this->listVisibleFields as $field) {
      $columns[] = ['data' => $field];
    }

    $columns[] = ['data' => 'actions', 'orderable' => false];

		return json_encode($columns);
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
}

/* End of File {class_name}Base.php */
/* Path: ./App/CrudBase/Controllers/{class_name}Base.php */
