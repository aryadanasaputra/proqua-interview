<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class Auth extends BaseController {
  protected $userModel;
  
  public function __construct(){
    $this->userModel = new UserModel();
  }

  public function index(){
    $viewData['url'] = $url = $this->request->getGet('url') ?? '';
    if(session()->get('id')) return redirect()->to($url);
    return view("login/view_login",$viewData);
  }

  public function login(){
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password') ?? '';
    $rememberMe = (bool) $this->request->getPost('remember_me');
    $user = $this->userModel->where('username', $username)->first();
    if(empty($user)){
      return $this->response->setJSON(["result"=>0,"message"=>"Username tidak ditemukan"]);
    }
    if(!password_verify($password, $user->password)){
      return $this->response->setJSON(["result"=>0,"message"=>"Kata sandi tidak sesuai"]);
    }
    /** Log Login */
    $this->db->table('user')
      ->where('id',$user->id)
      ->update(['last_login' => date('Y-m-d H:i:s')]);
    $this->db->table('log_login')
      ->set('user_id',$user->id)
      ->set('ip',$this->request->getIPAddress())
      ->insert();

    $roles = $this->userModel->getRole($user->id);
    // if(empty($roles)){
    // 	return $this->response->setJSON(["result"=>0,"message"=>"Anda tidak memiliki akses, hubungi Admin !"]);
    // }
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
    if($rememberMe){
      $jwtPayload = [
        'username' => $user->username,
        'id' => $this->request->getIPAddress(),
        'iat' => time(),
      ];
      $jwt = $this->template->jwt($jwtPayload, env('jwtRememberme.secretkey'));
      set_cookie([
        'name' => env('jwtRememberme.cookies'),
        'value' => $jwt,
        'expire' => (86400 * 30), // expired 30 days
        'secure' => FALSE,
      ]);
    }
    return $this->response->setJSON(["result"=>1]);
  }

  public function logout(){
    session()->destroy();
    delete_cookie(env('jwtRememberme.cookies'), '', '/', '');
    setcookie(env('jwtRememberme.cookies'), '', time() - 3600, '/');

    return redirect()->to('/');
  }
  
}