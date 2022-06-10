<?php namespace Harlleimazetti\Ci4tools\Fileprocess;

class Fileprocess
{
  protected $result;
  protected $config;
  protected $request;
  protected $folderName;
  protected $data;
  protected $db;
  protected $auth;
  protected $uploadedFiles;
  protected $files;
  protected $tenant;

  function __construct($request = null, $folderName = null, $data = [])
  {
    $this->result         = new \stdClass();
    $this->config         = $this->getConfig();
    $this->request        = $request ? $request : \Config\Services::request();
    $this->folderName     = $folderName;
    $this->data           = $data;
    $this->db             = \Config\Database::connect();
    $this->auth           = service('auth');
    $this->uploadedFiles  = $this->request->getFiles();
    $this->files          = [];
  }

  public function validate()
  {
    foreach($this->request->getFiles() as $file) {
      $validateMymeType = $this->validateMymeType($file);
      $validateFileSize = $this->validateFileSize($file);
      $validateFile = $validateMymeType && $validateFileSize;

      if ($validateFile) {
        $this->files[] = $file;
      }
    }

    return $this->result;
  }

  public function store()
  {
    $currentUser = $this->auth->user();
    
    if (!$currentUser) {
      $this->result->success = false;
      $this->result->status = 'er';
      $this->result->messages[] = 'Operação não permitida ';
      $this->result->errors[]   = 'Operação não permitida ';
      return $this->result;
    }

    foreach ($this->files as $file)
    {
      $tenantFolder = 'tenant'.$currentUser->tenant_id;
      $pda_id       = $this->request->getPost('pda_id');
      $folderName   = $this->request->getPost('folder_name');
      $fileName     = $file->getClientName();
  
      $file->store($tenantFolder.DIRECTORY_SEPARATOR.$folderName);
  
      $filePath     = UPLOADPATH.$tenantFolder.DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR.$file->getName();
      $hashName     = $file->getName();
      $storedFile   = new \CodeIgniter\Files\File($filePath);
  
      $data = array(
        'tenant_id'   => $currentUser->tenant_id,
        'pda_id'      => $pda_id,
        'remessa_id'  => $this->request->getPost('remessa_id'),
        'data'        => date('Y-m-d'),
        'hora'        => date('H:i:s'),
        'nome'        => $fileName,
        'nome_hash'   => $hashName,
        'formato'     => $storedFile->getMimeType(),
        'tamanho'     => $storedFile->getSize(),
        'path'        => $storedFile->getRealPath(),
      );

      $data = array_merge($data, $this->data);
  
      print_r($data);
  
      /*
      $result = $fileModel->store($data);
  
      if ($result->success === false) {
        $this->result->status = 'er';
        $this->result->messages[] = 'Erro ao salvar o arquivo';
        $this->result->errors[]   = 'Erro ao salvar o arquivo '.$file->getClientName();
      }
      */
    }

    $this->result->status = 'ok';
    $this->result->messages[] = 'Arquivo salvo com sucesso';
    return $this->result;
  }

  private function validateMymeType($file) {
    if (!in_array($file->getMimeType(), $this->config->allowedImageMymeTypes) &&
        !in_array($file->getMimeType(), $this->config->allowedFileMymeTypes) &&
        !in_array($file->getMimeType(), $this->config->allowedMymeTypes))
    {
      $this->result->success = false;
      $this->result->status = 'er';
      $this->result->messages[] = 'Tipo de arquivo não permitido '.$file->getClientName();
      $this->result->errors[]   = 'Tipo de arquivo não permitido '.$file->getClientName();
      return false;
    }

    return true;
  }

  private function validateFileSize($file) {
    if ($file->getSize() > $this->config->maxUploadFileSize) {
      $this->result->success = false;
      $this->result->status = 'er';
      $this->result->messages[] = 'Arquivo é maior do que o tamanho máximo permitido '.$file->getClientName();
      $this->result->errors[]   = 'Arquivo é maior do que o tamanho máximo permitido '.$file->getClientName();
      return false;
    }

    return true;
  }

  private function getConfig() {
    $config = config('Ci4tools');
    return $config;
  }
}
