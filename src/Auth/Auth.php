<?php namespace Harlleimazetti\Ci4tools\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
  protected $request;
  protected $host;
  protected $result;

  function __construct()
  {
    $uri = new \CodeIgniter\HTTP\URI(base_url());

    $this->host     = $uri->getHost();
    $this->request  = \Config\Services::request();
    $this->result   = new \stdClass();
  }

  public function login($credentials = [])
  {
    if (empty($credentials)) {
      $this->result->success = false;
      $this->result->message[] = 'Dados de acesso não foram informados corretamente';
      return $this->result;
    }

    if ($credentials['login'] != 'harlleimazetti@gmail.com' || $credentials['password'] != 'mazetti') {
      $this->result->success = false;
      $this->result->message[] = 'Login ou senha inválidos';
      return $this->result;
    }

    $user = [
      'id' => '1',
      'tenant_id' => '1',
      'nome' => 'Harllei Mazetti',
      'email' => 'harlleimazetti@gmail.com',
    ];

    $algo = 'HS256';

    $key = $this->getServerKey();
    $iat = time();
    $nbf = time();
    $exp = time() + 60;

    $payload = array(
      "iss" => $this->host,
      "aud" => $this->host,
      "iat" => $iat,
      "exp" => $exp,
      "user" => $user,
    );

    $jwt = $this->encodeJWT($payload, $key, $algo);

    $this->result->success = true;
    $this->result->message[] = 'Login efetuado com sucesso';
    $this->result->token = $jwt;

    return $this->result;
  }

  public function verify() {
    $key  = $this->getServerKey();
    $algo = 'HS256';

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
