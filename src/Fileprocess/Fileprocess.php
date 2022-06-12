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
  protected $errorFiles;
  protected $storedFiles;
  protected $tenant;

  function __construct($request = null, $folderName = null, $data = [])
  {
    $this->result         = new \stdClass();
    $this->config         = $this->getConfig();
    $this->request        = $request ? $request : \Config\Services::request();
    $this->folderName     = $folderName ? $folderName : $this->createFolder();
    $this->data           = $data;
    $this->db             = \Config\Database::connect();
    $this->auth           = service('auth');
    $this->uploadedFiles  = $this->request->getFiles();
    $this->files          = [];
    $this->errorFiles     = [];
    $this->storedFiles    = [];
  }

  public function getFiles() {
    return $this->files;
  }

  public function getStoredFiles() {
    return $this->storedFiles;
  }

  public function validate()
  {
    foreach($this->uploadedFiles as $file) {
      $validateMymeType = $this->validateMymeType($file);
      $validateFileSize = $this->validateFileSize($file);
      $validateFile = $validateMymeType && $validateFileSize;

      if ($validateFile) {
        $this->files[] = $file;
      } else {
        $this->errorFiles[] = $file;
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
      $fileModel = $this->defineFileModel($file);

      if (!$fileModel) {
        $this->result->status = 'er';
        $this->result->messages[] = 'Não foi possível salvar o arquivo '.$file->getClientName();
        $this->result->errors[]   = 'Não foi possível salvar o arquivo '.$file->getClientName();
        continue;
      }

      $tenantFolder = 'tenant'.$currentUser->tenant_id;
      $folderName   = $this->folderName;
      $fileName     = $file->getClientName();
  
      $file->store($tenantFolder.DIRECTORY_SEPARATOR.$folderName);
  
      $filePath     = UPLOADPATH.$tenantFolder.DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR.$file->getName();
      $hashName     = $file->getName();
      $storedFile   = new \CodeIgniter\Files\File($filePath);
  
      $data = array(
        'tenant_id'   => $currentUser->tenant_id,
        'data'        => date('Y-m-d'),
        'hora'        => date('H:i:s'),
        'nome'        => $fileName,
        'nome_hash'   => $hashName,
        'formato'     => $storedFile->getMimeType(),
        'tamanho'     => $storedFile->getSize(),
        'path'        => $storedFile->getRealPath(),
      );

      $data = array_merge($data, $this->data);
  
      $result = $fileModel->store($data);
  
      if ($result->success === false) {
        $this->result->status = 'er';
        $this->result->messages[] = 'Erro ao salvar o arquivo '.$file->getClientName();
        $this->result->errors[]   = 'Erro ao salvar o arquivo '.$file->getClientName();
        continue;
      }

      $data['id'] = $fileModel->getInsertID();
      $this->storedFiles[] = $data;
    }

    $this->result->status = 'ok';
    $this->result->messages[] = 'Processamento dos arquivos enviados foi concluído';
    return $this->result;
  }

  private function createFolder()
  {
    $length = 10;
    $folderName = date('YmdHis').substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    return $folderName;
  }

  private function defineFileModel($file)
  {
    if (in_array($file->getMimeType(), array('image/jpg','image/jpeg','image/png','image/gif'))) {
      $fileModel = new \App\Models\ImagemModel();
    } else if (in_array($uploadedFile->getMimeType(), array('text/plain' /*, 'application/vnd.ms-excel'*/))) {
      $fileModel = new \App\Models\ArquivoModel();
    } else {
      return false;
    }

    return $fileModel;
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
