<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Libraries\Template;

class PrivilegeFilter implements FilterInterface{
  protected $template;
  
  public function __construct() {
    $this->template = new Template;
  }


  public function before(RequestInterface $request, $arguments = null){
    if(!in_array($arguments[0], session()->get('roles'))){
      if(request()->isAJAX()){
        response()->setStatusCode(403)->setBody("access denied")->send();
        exit;
      }
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
    return;
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){}
}
