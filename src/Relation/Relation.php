<?php namespace Harlleimazetti\Ci4tools\Relation;

define('DS', DIRECTORY_SEPARATOR);
define('VENDOR_NAME', 'harlleimazetti');
define('PACKAGE_NAME', 'ci4tools');

class Relation  {
	protected $db;
  protected $relationType;
  protected $record;
	protected $parentTable;
  protected $parentTablePk;
  protected $parentTableFk;
  protected $parentTableModel;
	protected $childTable;
  protected $childTablePk;
  protected $childTableFk;
  protected $childTableModel;
  protected $linkTable;
  protected $linkTableModel;

  function __construct($relation = null)
	{
		$this->db = \Config\Database::connect();

    if (isset($relation)) {
      $this->setRelation($relation);
    }
  }

  /**
   * Set Relation parameters.
   *
   * @param array $relation with the Relation parameters
   *
   * @return null
   */
  public function setRelation($relation) {
    $this->setRelationType($relation->type);
    $this->setRecord($relation->record);

    $this->setParentTable($relation->parentTable);
    $this->setChildTable($relation->childTable);

    if ($this->relationType == 'manyToMany') {
      $linkTable = $this->defineLinkTable($this->parentTable, $this->childTable);
      $this->setLinkTable($linkTable);
    }

    $keys = $this->extractKeys();

    $this->parentTablePk = $keys['parentTablePk'];
    $this->parentTableFk = $keys['parentTableFk'];

    $this->childTablePk = $keys['childTablePk'];
    $this->childTableFk = $keys['childTableFk'];

    $this->parentTableModel = ucfirst($this->parentTable."Model");
    $this->childTableModel = ucfirst($this->childTable."Model");
    $this->linkTableModel = ucfirst($this->linkTable."Model");
  }

  public function setRelationType($relationType)
  {
    $this->relationType = $relationType;
  }

  public function setRecord($record)
  {
    $this->record = $record;
  }

  public function setParentTable($parentTable)
  {
    $this->parentTable = $parentTable;
  }

  public function setChildTable($childTable)
  {
    $this->childTable = $childTable;
  }

  public function setLinkTable($linkTable)
  {
    $this->linkTable = $linkTable;
  }

  public function getrelationType()
  {
    return $this->relationType;
  }

  public function getRecord($record)
  {
    return $this->record;
  }

  public function getParentTable()
  {
    return $this->parentTable;
  }

  public function getChildTable()
  {
    return $this->childTable;
  }

  public function getLinkTable()
  {
    return $this->linkTable;
  }

  /**
   * Returns Records according to Relation parameters
   *
   * @return Model Result
   */
  public function get() {
    switch ($this->relationType) {
      case 'manyToOne':
        return $this->manyToOne($this->record);
        break;
      case 'oneToMany':
        return $this->oneToMany($this->record);
        break;
      case 'manyToMany':
        return $this->manyToMany($this->record);
        break;
      default:
        return null;
    }
  }

  public function manyToOne($record)
  {
    if (empty($this->parentTable) || empty($this->childTable)) {
      return null;
    }

    $model = model("App\\Models\\".$this->parentTableModel, false);

    $result = $model->where($this->parentTablePk, $record->{$this->parentTableFk})
                    ->findAll();
    return $result;
  }

  public function oneToMany($record)
  {
    if (empty($this->parentTable) || empty($this->childTable)) {
      return null;
    }

    $model = model("App\\Models\\".$this->childTableModel, false);

    $result = $model->where($this->parentTableFk, $record->{$this->parentTablePk})
                    ->findAll();
    return $result;
  }

  public function manyToMany($record)
  {
    if (empty($this->parentTable) || empty($this->childTable)) {
      return null;
    }

    $modelLink = model("App\\Models\\".$this->linkTableModel, false);
    $model = model("App\\Models\\".$this->childTableModel, false);

    $linkResult = $modelLink->where($this->parentTableFk, $record->{$this->parentTablePk})
                  ->findColumn($this->childTableFk);

    $result = $model->find($linkResult);
    return $result;
  }

  protected function extractKeys() {
    $keys = [];
    
    $parentTablePk = $this->extractPk($this->parentTable);
    $childTablePk = $this->extractPk($this->childTable);

    if ($this->relationType == 'manyToMany') {
      $parentTableFk = $this->extractFk($this->parentTable, $this->linkTable);
      $childTableFk = $this->extractFk($this->childTable, $this->linkTable);
    } else {
      $parentTableFk = $this->extractFk($this->parentTable, $this->childTable);
      $childTableFk = $this->extractFk($this->childTable, $this->parentTable);
    }

    $keys['parentTablePk'] = $parentTablePk;
    $keys['childTablePk'] = $childTablePk;

    $keys['parentTableFk'] = $parentTableFk;
    $keys['childTableFk'] = $childTableFk;

    return $keys;
  }

  protected function extractPk($table) {
    if (empty($table)) {
      return null;
    }

    $indexes = $this->db->getIndexData($table);

    if (array_key_exists('PRIMARY', $indexes)) {
      $pk = $indexes['PRIMARY']->fields[0];
    }

    return $pk;
  }

  protected function extractFk($table1, $table2) {
    if (empty($table1) || empty($table2)) {
      return null;
    }

    $foreignKey = (array)$this->db->getForeignKeyData($table2);

    $index = array_search($table1, array_column($foreignKey, 'foreign_table_name'));

    if (!isset($foreignKey[$index])) {
      return null;
    }

    $fk = $foreignKey[$index]->column_name;

    return $fk;
  }

  protected function defineLinkTable($parentTable, $childTable) {
    $linkTable = $parentTable."_".$childTable;
    if (!$this->db->tableExists($linkTable)) {
      $linkTable = $childTable."_".$parentTable;
    }
    return $linkTable;
  }
}