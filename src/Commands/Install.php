<?php namespace Harlleimazetti\Ci4tools\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

use Harlleimazetti\Ci4tools\Crud\Crud;

class Install extends BaseCommand
{
  protected $group       = 'ci4tools';
  protected $name        = 'ci4tools:install';
  protected $description = 'Install Ci4Tools Admin.';

  function __construct()
  {

  }
  
  public function run(array $params)
  {
    $crud = new Crud();
    $crud->install();
    exit;
  }
}