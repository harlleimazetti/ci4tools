<?php namespace Harlleimazetti\Ci4tools\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
  function __construct()
  {
    
  }

  public function login($credentials = []) {
    $key = getenv('app.serverKey');
    echo "KEY: ".$key."\r\n\r\n";
    $payload = array(
      "iss" => "http://example.org",
      "aud" => "http://example.com",
      "iat" => 1356999524,
      "nbf" => 1357000000
    );

    $jwt = $this->encodeJWT($payload, $key, 'HS256');
    $decoded = $this->decodeJWT($jwt, new Key($key, 'HS256'));

    echo $jwt;
    print_r($decoded);
  }

  public function encodeJWT($payload, $key, $algo) {
    $jwt = JWT::encode($payload, $key, $algo);
    return $jwt;
  }

  public function decodeJWT($jwt, $key, $algo) {
    $decoded = JWT::decode($jwt, new Key($key, $algo));
    return $decoded;
  }
}
