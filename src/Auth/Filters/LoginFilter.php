<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $auth = service('auth');
    $userLogged = $auth->verify();

    if (!$userLogged->success) {
      if ($request->isAjax()) {
        $response = \Config\Services::response();
        $response->setStatusCode(401);
        $response->setJSON($userLogged);
        $response->send();
        exit;
      }
      return redirect()->to(base_url('sistema/login'));
      exit;
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    
  }
}