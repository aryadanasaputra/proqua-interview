<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Libraries\Template;
use App\Models\UserModel;

class AuthFilter implements FilterInterface{
  protected $template;
  protected $userModel;
  
  public function __construct() {
    $this->template = new Template;
    $this->userModel = new UserModel();
  }


  public function before(RequestInterface $request, $arguments = null){
    if(session()->get('id')){
      return;
    }

    /**
     * Remember Me
     */
    if(get_cookie(env('jwtRememberme.cookies'))){
      $jwt = get_cookie(env('jwtRememberme.cookies'));
      $jwtPayload = $this->template->jwtDecode((string) $jwt,env('jwtRememberme.secretkey'));
      if(!empty(get_object_vars($jwtPayload))){
        if($jwtPayload->id == request()->getIPAddress()){
          if($jwtPayload->username){
            $user = $this->userModel->where('username', $jwtPayload->username)->first();
            if(!empty($user)){
              $roles = $this->userModel->getRole($user->id);
              $menus = $this->userModel->getMenu($user->id);
              $this->template->buildCleanTree($menus);
              $dataSess = [
                  'id' => $user->id,
                  'email' => $user->email,
                  'username' => $user->username,
                  'name' => $user->name,
                  'roles' => array_column($roles,'code'),
                  'menus' => $menus,
                ];
              session()->set($dataSess);

              /** set ulang token */
              $jwtPayload->iat = time();
              $jwtPayload = (array) $jwtPayload;
              $jwt = $this->template->jwt($jwtPayload, env('jwtRememberme.secretkey'));
              set_cookie([
                  'name' => env('jwtRememberme.cookies'),
                  'value' => $jwt,
                  'expire' => (86400 * 30), // expired 30 days
                  'secure' => FALSE,
                ]);
              return;
            }
          }
        }
      }
    }

    if(request()->isAJAX()){
      response()->setStatusCode(403)->setBody("session expired")->send();
      exit;
    }
    
    $url = str_replace(base_url(),"",(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    $url = urlencode($url);
    $urlRedirect = "login".(!empty($url) ? "?url=".$url : "");
    return redirect()->to(base_url($urlRedirect));
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){}
}
