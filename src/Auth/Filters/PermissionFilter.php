<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $auth = service('auth');
    $router = service('router');
    
    //$controller  = $router->controllerName();
    //$method = $router->methodName();

    //echo $controller." - ".$method;

    /*
    if (!$auth->isLoggedIn()) {
      return redirect()->to(base_url('sistema/login'));
      exit;
    }
    */
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    
  }
}