<?php namespace Harlleimazetti\Ci4tools\Relation;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('VENDOR_NAME') or define('VENDOR_NAME', 'harlleimazetti');
defined('PACKAGE_NAME') or define('PACKAGE_NAME', 'ci4tools');

class Relation  {
	protected $db;
  protected $table;
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
  protected $relatedTables = [];
  protected $linkTables = [];
  protected $tenant;

  function __construct($relation = null, $tenant = null)
	{
		$this->db = \Config\Database::connect();

    if (isset($relation)) {
      $this->setRelation($relation);
    }

    if (isset($tenant)) {
      $this->setTenant($tenant);
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

  /**
   * Set Tenant
   *
   * @param object $tenant
   *
   * @return null
   */
  public function setTenant($tenant) {
    $this->tenant = $tenant;
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

  public function getRelationType()
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
  public function get()
  {
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

    $model->where($this->parentTablePk, $record->{$this->parentTableFk});

    if (!empty($this->tenant)) {
      $model->withTenant($this->tenant);
    }

    $result = $model->findAll();

    return $result;
  }

  public function oneToMany($record)
  {
    if (empty($this->parentTable) || empty($this->childTable)) {
      return null;
    }

    $model = model("App\\Models\\".$this->childTableModel, false);

    $model->where($this->parentTableFk, $record->{$this->parentTablePk});

    if (!empty($this->tenant)) {
      $model->withTenant($this->tenant);
    }

    $result = $model->findAll();
    
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

    if (!empty($this->tenant)) {
      $model->withTenant($this->tenant);
    }

    $result = $model->find($linkResult);
    
    return $result;
  }

  protected function extractKeys() {
    $keys = [];
    
    $parentTablePk = $this->extractPk($this->parentTable);
    $childTablePk  = $this->extractPk($this->childTable);

    if ($this->relationType == 'manyToMany') {
      $parentTableFk = $this->extractFk($this->parentTable, $this->linkTable);
      $childTableFk  = $this->extractFk($this->childTable, $this->linkTable);
    } else {
      $parentTableFk = $this->extractFk($this->parentTable, $this->childTable);
      $childTableFk  = $this->extractFk($this->childTable, $this->parentTable);
    }

    $keys['parentTablePk'] = $parentTablePk;
    $keys['childTablePk']  = $childTablePk;

    $keys['parentTableFk'] = $parentTableFk;
    $keys['childTableFk']  = $childTableFk;

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

  protected function extractFk($table1, $table2)
  {
    if (empty($table1) || empty($table2)) {
      return null;
    }

    $foreignKey = (array)$this->db->getForeignKeyData($table2);

    $index = array_search($table1, array_column($foreignKey, 'foreign_table_name'));

    if ($index === 0 || $index > 0) {
      $fk = $foreignKey[$index]->column_name;
      return $fk;
    }

    return null;
  }

  protected function defineLinkTable($parentTable, $childTable) {
    $linkTable = $parentTable."_".$childTable;
    if (!$this->db->tableExists($linkTable)) {
      $linkTable = $childTable."_".$parentTable;
      if (!$this->db->tableExists($linkTable)) {
        return null;
      }
    }
    return $linkTable;
  }

  /**
   * Set Related tables to given Table
   * 
   * @param string $table
   *
   * @return null
   */
  public function setRelatedTables($table)
  {
		$fields   = $this->db->getFieldData($table);
		$keys     = $this->db->getForeignKeyData($table);
		$indexes  = $this->db->getIndexData($table);
    $tables   = $this->db->listTables();

    $this->linkTables = $this->setLinkTables($table);

    foreach ($tables as $relatedTable)
    {
      if (in_array($relatedTable, array_column($this->linkTables, 'linkTable'))) {
        continue;
      }

      if ($this->extractFk($table, $relatedTable)) {
        $this->addRelatedTable(
          $relationType = 'oneToMany',
          $parentTable  = $table,
          $childTable   = $relatedTable,
          $record       = null
        );
      }

      if ($this->extractFk($relatedTable, $table)) {
        $this->addRelatedTable(
          $relationType = 'manyToOne',
          $parentTable  = $relatedTable,
          $childTable   = $table,
          $record       = null
        );
      }

      /*
      $this->setRelation($relation);

      echo "Relation Type: ".$this->relationType."\r\n";
      echo "Parent Table: ".$this->parentTable."\r\n";
      echo "Parent PK: ".$this->parentTablePk."\r\n";
      echo "Parent FK: ".$this->parentTableFk."\r\n";
      echo "Child Table: ".$this->childTable."\r\n";
      echo "Child PK: ".$this->childTablePk."\r\n";
      echo "Child FK: ".$this->childTableFk."\r\n";
      echo "********************"."\r\n\r\n\r\n\r\n\r\n";
      */
    }
    
    print_r($this->relatedTables);
  }

  public function addRelatedTable($relationType = null, $parentTable = null, $childTable = null, $linkTable = null, $record = null)
  {
    if (empty($relationType) || empty($parentTable) || empty($childTable)) {
      return null;
    }

    $this->resetObject();

    $relation = (object)[
      'type'        => $relationType,
      'parentTable' => $parentTable,
      'childTable'  => $childTable,
      'linkTable'   => $linkTable,
      'record'      => $record,
    ];

    $this->setRelation($relation);

    $relation->parentTablePk    = $this->parentTablePk;
    $relation->parentTableFk    = $this->parentTableFk;
    $relation->parentTableModel = $this->parentTableModel;

    $relation->childTablePk     = $this->childTablePk;
    $relation->childTableFk     = $this->childTableFk;
    $relation->childTableModel  = $this->childTableModel;

    $relation->linkTableModel   = $this->linkTableModel;

    array_push($this->relatedTables, $relation);
  }

  public function addLinkTable($relationType = null, $parentTable = null, $childTable = null, $linkTable = null, $record = null)
  {
    if (empty($parentTable) || empty($childTable) || empty($linkTable)) {
      return null;
    }

    array_push($this->linkTables, (object)[
      'relationType'  => 'manyToMany',
      'parentTable'   => $parentTable,
      'childTable'    => $childTable,
      'linkTable'     => $linkTable,
      'record'        => $record,
    ]);
  }

  public function setLinkTables($table)
  {
    $tables = $this->db->listTables();

    $linkTables = [];

    foreach ($tables as $relatedTable)
    {
      if ($linkTable = $this->defineLinkTable($table, $relatedTable))
      {
        $relation = (object)[
          'relationType'  => 'manyToMany',
          'parentTable'   => $table,
          'childTable'    => $relatedTable,
          'linkTable'     => $linkTable,
          'record'        => null
        ];

        array_push($linkTables, $relation);

        $this->addRelatedTable(
          $relationType = 'manyToMany',
          $parentTable  = $table,
          $childTable   = $relatedTable,
          $linkTable    = $linkTable,
          $record       = null
        );
      }
    }

    return $linkTables;
  }

  protected function resetObject() {
    $this->relationType     = null;
    $this->record           = null;
    $this->parentTable      = null;
    $this->parentTablePk    = null;
    $this->parentTableFk    = null;
    $this->parentTableModel = null;
    $this->childTable       = null;
    $this->childTablePk     = null;
    $this->childTableFk     = null;
    $this->childTableModel  = null;
    $this->linkTable        = null;
    $this->linkTableModel   = null;
  }
}