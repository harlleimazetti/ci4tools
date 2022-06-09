<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Ci4tools extends BaseConfig
{
  public $themeName             = 'smartadmin';
  public $themeAdminName        = 'materialadmin';
  public $baseURL               = 'http://localhost/danms/appweb/';
  public $logTable              = 'log';
  public $serverKey             = '11acd0f666c81fae6f87a86896c82d67a0f5a45489f9390ecc7271a0e8e2361f';
  public $allowedImageMymeTypes = ['image/jpg','image/jpeg','image/png','image/gif'];
  public $allowedFileMymeTypes  = ['text/plain'];
  public $allowedMymeTypes      = [];
  public $maxUploadFileSize     = 5242880;
}