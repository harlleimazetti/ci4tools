<?php namespace Harlleimazetti\Ci4tools\Relation;

use CodeIgniter\CLI\CLI;

define('DS', DIRECTORY_SEPARATOR);
define('VENDOR_NAME', 'harlleimazetti');
define('PACKAGE_NAME', 'ci4tools');

class Relation  {
	protected $db;
	protected $parentTable;
	protected $childTable;
  protected $linkTable;
  protected $pk;
  protected $fk;
  protected $parentPk;
  protected $parentFk;
  protected $childPk;
  protected $childFk;
  protected $pkField;
  protected $fkField;
  protected $parentPkField;
  protected $parentFkField;
  protected $childPkField;
  protected $childFkField;

  function __construct()
	{
		$this->db = \Config\Database::connect();
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

  public function getParentTable($parentTable)
  {
    return $this->parentTable;
  }

  public function getChildTable($childTable)
  {
    return $this->childTable;
  }

  public function getLinkTable($linkTable)
  {
    return $this->linkTable;
  }

  public function n1(
    $parentTable = '',
    $childTable = '',
    $pk = '',
    $fk = ''
  )
  {
    if (empty($parentTable) || empty($childTable)) {
      return null;
    }

    if (empty($pk)) {
      $pk = $this->extractPk($parentTable);
    }

    if (empty($fk)) {
      $fk = $this->extractFk($parentTable);
    }
  }

  protected function extractPk($tableName) {
    if (empty($tableName)) {
      return null;
    }

    $keys = array();

    $indexes = $this->db->getIndexData($tableName);
    //print_r($indexes);
  }
}