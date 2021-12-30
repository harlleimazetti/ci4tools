<?php namespace App\Crudbase\Models;

use CodeIgniter\Model;
use App\Entities\{class_name};
use App\Crudbase\Validation\{class_name}Validation;
use Harlleimazetti\Ci4tools\Relation\Relation;

class {class_name}ModelBase extends Model
{
	protected $db;
	protected $builder;
	protected $fields;
	protected $emptyRecord;
	protected $countAllRecords;
	protected $countResultsRecords;
  protected $relations = [];

	protected $table              = '{table}';
	protected $primaryKey         = 'id';
	protected $returnType         = 'App\Entities\{class_name}';
	protected $useTimestamps      = true;
	protected $useSoftDeletes     = true;
	protected $createdField       = 'created_at';
	protected $deletedField       = 'deleted_at';
	protected $updatedField       = 'updated_at';
	protected $skipValidation     = false;
	protected $validationRules    = [];
	//protected $validationMessages = [];
	protected $allowedFields      = [{record_allowed_fields}];

  protected $afterFind          = ['findRelations'];

	function __construct() {
		parent::__construct();
		//$this->fields = array_fill_keys($this->db->list_fields("{table}"), '');

		$database = \Config\Database::connect();
		$this->db	= $database->table('{table}');

    ${table}Validation = new {class_name}Validation();
    $this->validationRules = ${table}Validation->getRules();
	}

  protected function findRelations(array $data)
  {
    foreach($data['data'] as $record) {
      foreach($this->relations as $r) {
        $r->record = $record;
        $relation = new Relation($r);
        $record->{$r->name} = $relation->get();
      }
    }
    return $data;
  }

  public function manyToOne($table)
  {
    $relation = (object)[
      'name' => $table,
      'type' => 'manyToOne',
      'parentTable'=> $table,
      'childTable'=> $this->table
    ];
    array_push($this->relations, $relation);
    return $this;
  }

  public function oneToMany($table)
  {
    $relation = (object)[
      'name' => $table,
      'type' => 'oneToMany',
      'parentTable'=> $this->table,
      'childTable'=> $table
    ];
    array_push($this->relations, $relation);
    return $this;
  }

  public function manyToMany($table)
  {
    $relation = (object)[
      'name' => $table,
      'type' => 'manyToMany',
      'parentTable'=> $this->table,
      'childTable'=> $table
    ];
    array_push($this->relations, $relation);
    return $this;
  }

	function countAll() {
		$this->countAllRecords = $this->db->count_all('{table}');
		return $this->countAllRecords;
	}

	function countResults() {
		return $this->countResultsRecords;
	}

	function getFields() {
		return $this->fields;
	}

	function getAll($params = array()) {
		if (!isset($params['OR'])) { $params['OR'] = array(); }
		if (!isset($params['AND'])) { $params['AND'] = array(); }
		if (!isset($params['LIKE'])) { $params['LIKE'] = array(); }
		$r = $this->get_{record}($params);
		return $r;
	}

	function get{class_name}($params)
	{
		if (!isset($params['OR'])) { $params['OR'] = array(); }
		if (!isset($params['AND'])) { $params['AND'] = array(); }
		if (!isset($params['LIKE'])) { $params['LIKE'] = array(); }
		$this->db->select('{table}.*');
		//$this->db->from('{table}');
		$this->db->where($params['AND']);
		$this->db->orWhere($params['OR']);
		$this->db->like($params['LIKE']);
		$q = $this->db->get();
		return $q->getResult();
		foreach ($q->result() as $reg) {
			$campos = get_object_vars($reg);
			foreach ($campos as $campo => $valor) {
				if ( ($campo == 'valor') or (substr($campo, 0, 6) == 'valor_') ) {
					$reg->{$campo} = number_format($reg->{$campo}, 2, ',', '.');
				}
				if ( ($campo == 'data') or ($campo == 'nascimento') or ($campo == 'admissao') or (substr($campo, 0, 6) == 'data_') ) {
					$reg->{$campo} = date('d/m/Y', strtotime($reg->{$campo}));
				}
			}
		}
		//echo get_class($this);
		//echo $this->db->last_query(); exit;
		if ($q->num_rows() > 0) {
        	if ($q->num_rows() >= 1) {
				$q = $this->relation->set('{table}', $q, TRUE);
			}
			return $q->result();
		} else {
			$r = array((object)$this->campos);
			$r = $this->relation->set('{table}', $r, FALSE);
			return $r;
		}
	}

	function getDatatablesColumns()
	{
		$this->db->select('config');
		$this->db->from('table_def');
		$this->db->where(array('table' => '{table}'));
		$q = $this->db->get();
		$r = $q->result();
		$r = reset($r);
		$config = json_decode($r->config);
		$colunas = array();
		foreach ($config as $config) {
			if ($config->mostrar == 'S') {
				array_push($colunas, array('title' => $config->titulo));
			}
		}
		array_push($colunas, array('title' => 'Ações'));
		return $colunas;
	}

	function getDatatablesRecords($params = array())
	{
		if (!isset($params['OR'])) { $params['OR'] = array(); }
		if (!isset($params['AND'])) { $params['AND'] = array(); }
		if (!isset($params['LIKE'])) { $params['LIKE'] = array(); }
		$this->load->helper('my_datatables_helper');
		$this->load->library('datatables');
		$this->db->select('config');
		$this->db->from('table_def');
		$this->db->where(array('table' => '{table}'));
		$q = $this->db->get();
		$r = $q->result();
		$r = reset($r);
		$conf = json_decode($r->config);
		$campos = '';
		$colunas = array();
		//foreach ($this->campos as $campo) {
		foreach ($conf as $config) {
			if ($config->mostrar == 'S') {
				$campos .= $config->nome . ', ';
				array_push($colunas, array('title' => $config->titulo));
			}
		}
		array_push($colunas, array('title' => 'Ações'));
		$campos .= 'id AS acoes, ';
		$campos = substr($campos, 0, -2);
		$this->datatables->select($campos)->from("{table}")->where($params['AND']);
		$this->datatables->edit_column('id','$1','$this->formata_registro_id(id)');
		$this->datatables->edit_column('acoes','$1','$this->formata_acoes(acoes)');
		foreach ($conf as $config) {
			if ($config->mostrar == 'S') {
				if ( ($config->nome == 'valor') or (substr($config->nome, 0, 6) == 'valor_') ) {
					$this->datatables->edit_column("$config->nome",'$1','$this->formata_valor('."$config->nome".')');
				} else if ( ($config->nome == 'data') or (substr($config->nome, 0, 5) == 'data_') ) {
					$this->datatables->edit_column("$config->nome",'$1','$this->formata_data('."$config->nome".')');
				} else {
					$this->datatables->edit_column("$config->nome",'$1','$this->formata_coluna_datatables('."$config->nome".', "{table}", '.'col_'.$config->nome.')');
				}
			}
		}
		$data = json_decode($this->datatables->generate());
		return json_encode($data);
	}

	function erase($id)
	{
		$resultado = array();
		try {
			$this->db->where(array('id' => $id));
			$this->db->update('{table}', array('opt_deleted' => 1));
			//echo $this->db->last_query(); exit;
			$resultado['status'] = "ok";
			$resultado['mensagem'][] = 'Registro excluído com sucesso';
			return $resultado;
		}
		catch(Exception $e) {
			$resultado['status'] = "er";
			$resultado['mensagem'][] = 'Problemas na exclusão do registro: ' . $e->getMessage();
			return $resultado;
		}
	}

  function store($data) {
    ${table} = new \App\Entities\{class_name}();
    ${table}->fill($data);

    if (!$this->save(${table})) {
      $this->result['success'] = false;
      $this->result['message'][] = 'Problemas na gravação do registro';
      $this->result['errors'] = $this->errors();
      
      return $this->result;
    }

    $this->result['success'] = true;
    $this->result['message'][] = 'Registro salvo com sucesso';
    $this->result['errors'] = [];

    return $this->result;
  }

	function store_backup($registro, $id, $operacao_bd)
	{
		$resultado = array();
		$registro	= $this->relation->set_record_to_save('{table}', $registro);
		try {
			if ($operacao_bd == 'novo') {
				$this->db->insert('{table}', $registro);
				$id = $this->db->insert_id();
				$registro['id'] = $id;
			} else {
				$this->db->where('id', $id);
				$this->db->update('{table}', $registro);
			}
			$relations 	= $this->relation->set_relations_to_save('{table}', $registro);
			$this->relation->save_relations('{table}', $registro, $relations);
			$resultado['status'] = "ok";
			$resultado['id'] = $id;
			$resultado['mensagem'][] = 'Registro salvo com sucesso';
			return $resultado;
		}
		catch(Exception $e) {
			$resultado['status'] = "er";
			$resultado['mensagem'][] = 'Problemas na gravação do registro';
			$resultado['mensagem'][] = $e->getMessage();
			return $resultado;
		}
	}

}

/* End of File {class_name}ModelBase.php */
/* Path: ./App/CrudBase/Models/{class_name}ModelBase.php */
