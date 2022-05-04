<?php namespace Harlleimazetti\Ci4tools\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

use Harlleimazetti\Ci4tools\Tools\Ci4tools;

class Install extends BaseCommand
{
  protected $group       = 'ci4tools';
  protected $name        = 'ci4tools:install';
  protected $description = 'Install Ci4Tools';

  function __construct()
  {

  }
  
  public function run(array $params)
  {
    $tools = new Ci4tools();
    $tools->install();
    exit;
  }
}