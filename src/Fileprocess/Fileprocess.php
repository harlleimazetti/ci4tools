<?php namespace Harlleimazetti\Ci4tools\Fileprocess;

class Fileprocess
{
  protected $request;
  protected $result;
  protected $config;
  protected $tenant;
  protected $db;

  function __construct()
  {
    $this->result   = new \stdClass();
    $this->config   = $this->getConfig();
    $this->request  = \Config\Services::request();
    $this->db       = \Config\Database::connect();

    print_r($this->request);
  }

  private function getConfig() {
    $config = config('Ci4tools');
    return $config;
  }
}
