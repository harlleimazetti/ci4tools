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
  protected $tenant;
  protected $relations = [];
  protected $result;
  protected $log;

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

  protected $beforeUpdate       = ['includeTenant'];
  protected $beforeInsert       = ['includeTenant'];
  protected $afterFind          = ['findRelations'];

	function __construct() {
		parent::__construct();

    $this->result = new \stdClass();
    $this->log    = service('log');
    
		$database = \Config\Database::connect();
		$this->db	= $database->table('{table}');

    $this->fields	= $database->getFieldNames($this->table);

    ${table}Validation = new {class_name}Validation();
    $this->validationRules = ${table}Validation->getRules();
	}

  protected function includeTenant(array $data)
  {
    if (!empty($data['data']) && !empty($this->tenant)) {
      if (in_array('tenant_id', $this->fields)) {
        $data['data']['tenant_id'] = $this->tenant->id;
      }
    }

    return $data;
  }

  protected function findRelations(array $data)
  {
    if (!empty($data['data'])) {
      foreach($data['data'] as $record) {
        foreach($this->relations as $r) {
          $r->record = $record;
          $relation = new Relation($r, $this->tenant);
          $record->{$r->name} = $relation->get();
        }
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

  public function withTenant($tenant) {
    $this->tenant = $tenant;

    if (in_array('tenant_id', $this->fields)) {
      $this->builder()->where($this->table . '.tenant_id', $tenant->id);
    }
    
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

	function erase($id)
	{
		try {
      $this->where('id', $id)->delete();
      
      $this->result->success      = true;
      $this->result->record['id'] = $id;
      $this->result->messages[]   = 'Registro excluído com sucesso';
      $this->result->errors       = [];

      return (object)$this->result;

		} catch(\Exception $e) {
      $this->result->success      = false;
      $this->result->record['id'] = $id;
      $this->result->messages[]   = 'Problemas na exclusão do registro';
      $this->result->errors       = 'Problemas na exclusão do registro';

      return (object)$this->result;
		}
	}

  function store($data)
  {
    try {
      ${table} = new \App\Entities\{class_name}();
      ${table}->fill($data);

      if (!$this->save(${table})) {
        $this->result->success    = false;
        $this->result->messages[] = 'Problemas na gravação do registro';
        $this->result->errors     = $this->errors();
        
        return (object)$this->result;
      }
    } catch(\Exception $e) {
        $this->result->success    = false;
        $this->result->messages[] = 'Problemas na gravação do registro';
        $this->result->errors     = $this->errors();
        
        return (object)$this->result;
    }

    $record_id = empty(${table}->id) ? $this->getInsertID() : ${table}->id;

    $this->result->success      = true;
    $this->result->record['id'] = $record_id;
    $this->result->messages[]   = 'Registro salvo com sucesso';
    $this->result->errors       = [];

    return (object)$this->result;
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
