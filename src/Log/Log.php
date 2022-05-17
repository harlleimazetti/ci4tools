<?php namespace Harlleimazetti\Ci4tools\Log;

class Log
{
  protected $request;
  protected $result;
  protected $config;
  protected $tenant;
  protected $db;

  const EMERGENCY = 'emergency';
  const ALERT     = 'alert';
  const CRITICAL  = 'critical';
  const ERROR     = 'error';
  const WARNING   = 'warning';
  const NOTICE    = 'notice';
  const INFO      = 'info';
  const DEBUG     = 'debug';

  function __construct()
  {
    $this->result   = new \stdClass();
    $this->config   = $this->getConfig();
    $this->request  = \Config\Services::request();
    $this->db       = \Config\Database::connect();

    if (!$this->db->tableExists($this->config->logTable)) {
      return null;
		}

    $this->db->table($this->config->logTable);
  }

  public function log($level = INFO, $rawMessage = '', $context = [], $tenant = null)
  {
    if (empty($rawMessage)) {
      return null;
    }

    try {
      $message = $this->interpolate($rawMessage, $context);

      $data = [
        'tenant_id'   => isset($tenant) ? $tenant->id : null,
        'date'        => date('Y-m-d'),
        'time'        => date('H:i:s'),
        'level'       => $level,
        'message'     => $message,
        'raw_message' => $rawMessage,
        'context'     => json_encode($context),
        'request'     => json_encode($this->request),
      ];

      $this->db->table($this->config->logTable)->insert($data);

    } catch (Exception $e) {
      return null;
      //return $e->getMessage();
    }

    return null;
  }

  private function interpolate($message, array $context = [])
  {
    $replace = array();

    foreach ($context as $key => $val) {
      if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
        $replace['{' . $key . '}'] = $val;
      }
    }

    return strtr($message, $replace);
  }

  private function getConfig() {
    $config = config('Ci4tools');
    return $config;
  }
}
