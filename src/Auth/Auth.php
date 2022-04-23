<?php namespace Harlleimazetti\Ci4tools\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
  protected $request;
  protected $host;
  protected $result;
  protected $serverKey;
  protected $algo;

  function __construct()
  {
    $uri = new \CodeIgniter\HTTP\URI(base_url());

    $this->host       = $uri->getHost();
    $this->request    = \Config\Services::request();
    $this->result     = new \stdClass();
    $this->serverKey  = $this->getServerKey();
    $this->algo       = 'HS256';
  }

  public function login($credentials = [])
  {
    $userModel = new \App\Models\UserModel();

    if (empty($credentials)) {
      $this->result->success = false;
      $this->result->message[] = 'Dados de acesso não foram informados corretamente';
      return $this->result;
    }

    if ($credentials['login'] == '' || $credentials['password'] == '') {
      $this->result->success = false;
      $this->result->message[] = 'Login ou senha inválidos';
      return $this->result;
    }

    $user = $userModel
      ->where('login', $this->request->getPost('login'))
      ->first();

    if (!$user) {
      $this->result->success = false;
      $this->result->message[] = 'Usuário não encontrado';
      return $this->result;
    }

    if (!password_verify($this->request->getPost('password'), $user->password)) {
      $this->result->success = false;
      $this->result->message[] = 'Senha inválida';
      return $this->result;
    }

    $userData = [
      'id'        => $user->id,
      'tenant_id' => $user->tenant_id,
      'name'      => $user->name,
      'email'     => $user->email,
    ];

    $algo = $this->algo;
    $key  = $this->serverKey;
    $iat  = time();
    $nbf  = time();
    $exp  = time() + 60;

    $payload = array(
      "iss" => $this->host,
      "aud" => $this->host,
      "iat" => $iat,
      "exp" => $exp,
      "user" => $userData,
    );

    $jwt = $this->encodeJWT($payload, $key, $algo);

    $this->result->success = true;
    $this->result->message[] = 'Login efetuado com sucesso';
    $this->result->token = $jwt;

    return $this->result;
  }

  public function isLoggedIn()
  {
    $isLoggedIn = $this->verify();

    if ($isLoggedIn->success) {
      return true;
    }

    return false;
  }

  public function verify()
  {
    $key  = $this->serverKey;
    $algo = $this->algo;

    $authHeader = $this->request->getHeader('Authorization');

    if (empty($authHeader)) {
      $this->result->success = false;
      $this->result->message[] = 'Acesso negado - token não informado';
      return $this->result;
    }

    $token = $this->getBearerToken($authHeader->getValue());

    try {
      $decoded = $this->decodeJWT($token, $key, $algo);

      if (!$decoded) {
        $this->result->success = false;
        $this->result->message[] = 'Acesso negado';
        return $this->result;
      }

      $this->result->success = true;
      $this->result->message[] = 'Acesso concedido';
      $this->result->data = $decoded;
      return $this->result;

    } catch (\Exception $e) {
      $this->result->success = false;
      $this->result->message[] = 'Acesso negado';
      $this->result->errors = $e->getMessage();
      return $this->result;
    }
  }

  public function user_id()
  {
    $key  = $this->serverKey;
    $algo = $this->algo;

    $authHeader = $this->request->getHeader('Authorization');

    if (empty($authHeader)) {
      $this->result->success = false;
      $this->result->message[] = 'Acesso negado - token não informado';
      return $this->result;
    }

    $token = $this->getBearerToken($authHeader->getValue());

    try {
      $decoded = $this->decodeJWT($token, $key, $algo);

      if (!$decoded) {
        return null;
      }

      return $decoded->user->id;

    } catch (\Exception $e) {
      return null;
    }
  }

  public function encodeJWT($payload, $key, $algo) {
    $jwt = JWT::encode($payload, $key, $algo);
    return $jwt;
  }

  public function decodeJWT($jwt, $key, $algo) {
    $decoded = JWT::decode($jwt, new Key($key, $algo));
    return $decoded;
  }

  protected function getServerKey() {
    return getenv('app.serverKey');
  }

  protected function getBearerToken($headers) {
    if (!empty($headers)) {
      if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
        return $matches[1];
      }
    }
    return null;
  }
}
