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

    //if (!$auth->isLoggedIn()) {
    if (!$userLogged->success) {
      //return redirect()->to(base_url('sistema/login'));
      $this->response->setStatusCode(401);
			$this->response->setJSON($userLooged);
      return $this->response;
      exit;
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    
  }
}