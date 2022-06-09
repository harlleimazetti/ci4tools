<?php namespace Harlleimazetti\Ci4tools\Fileprocess;

class Fileprocess
{
  protected $request;
  protected $result;
  protected $config;
  protected $tenant;
  protected $files;
  protected $db;

  function __construct()
  {
    $this->result   = new \stdClass();
    $this->config   = $this->getConfig();
    $this->request  = \Config\Services::request();
    $this->db       = \Config\Database::connect();
    $this->files    = [];
  }

  public function validate() {
    foreach($this->request->getFiles() as $file) {
      $this->validateMymeType($file);
      $this->validateFileSize($file);
    }
  }

  private function validateMymeType($file) {
    if (!in_array($file->getMimeType(), $this->config->allowedImageMymeTypes) &&
        !in_array($file->getMimeType(), $this->config->allowedFileMymeTypes) &&
        !in_array($file->getMimeType(), $this->config->allowedMymeTypes))
    {
      $this->result->success = false;
      $this->result->status = 'er';
      $this->result->messages[] = 'Tipo de arquivo não permitido '.$file->getClientName();
      return $this->result;
    }
  }

  private function validateFileSize($file) {
    if ($file->getSize() > $this->config->maxUploadFileSize) {
      $this->result->success = false;
      $this->result->status = 'er';
      $this->result->messages[] = 'Arquivo é maior do que o tamanho máximo permitido '.$file->getClientName();
      return $this->result;
    }
  }

  private function getConfig() {
    $config = config('Ci4tools');
    return $config;
  }
}
