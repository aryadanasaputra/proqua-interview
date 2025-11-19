<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupModel;
use App\Controllers\BaseController;

class Index extends BaseController {
  protected $userModel;
  protected $groupModel;
  
  public function __construct(){
    $this->userModel = model(UserModel::class);
    $this->groupModel = new GroupModel();
  }
  
  public function index(){
    return redirect()->to('home');
  }
  
  public function home(){
    $viewData['bgMenu'] = ['bg-primary','bg-secondary','bg-info','bg-success','bg-warning','bg-danger','bg-gray-dark','bg-gray','bg-light','bg-indigo','bg-navy','bg-purple','bg-fuchsia','bg-pink','bg-maroon','bg-orange','bg-lime','bg-teal','bg-olive'];
    $viewData['menus'] = (session()->get('menus') ? : []);
    // $viewData['menus'] = ($this->input->cookie()[COOKIES_APP_NAME] ? json_decode($this->input->cookie()[COOKIES_APP_NAME])->menus : []);
    return view("view_home",$viewData);
  }

  /**
  * User Profile
  */
  public function getUserProfile(){
    $user = $this->userModel
      ->select([
        'name',
        'username',
        'email',
      ])
      ->find(session()->get('id'));
    if(!empty($user)){
      return $this->response->setJSON(["result"=>1,"user"=>$user]);
    }
  }

  public function saveUserProfile(){
    $user = $this->userModel->find(session()->get('id'));
    if(empty($user)){
      return $this->response->setJSON(["result"=>0,"message"=>"Data tidak ditemukan !"]);
    }
    $name = $this->request->getPost('name');
    $username = $this->request->getPost('username');
    $email = $this->request->getPost('email');
    $isChangePassword = $this->request->getPost('is_change_password');
    $userExist = $this->userModel
      ->where('id != ',$user->id)
      ->where('username',$username)
      ->first();
    if(!empty($userExist)){
      return $this->response->setJSON(["result"=>0,"message"=>"Username sudah digunakan, gunakan username lain !"]);
    }
    $data = [
      'id' => $user->id,
      'name' => $name,
      'username' => $username,
      'email' => $email,
      'updated_by' => session()->get('id'),
    ];
    if($isChangePassword){
      $oldPassword = (string) $this->request->getPost('old_password');
      $password = (string) $this->request->getPost('password');
      $rePassword = $this->request->getPost('re_password');
      if(!password_verify($oldPassword, $user->password)) return $this->response->setJSON(["result"=>0,"message"=>"Sandi lama Salah !"]);
      if($password != $rePassword) return $this->response->setJSON(["result"=>0,"message"=>"Ulangi Sandi Tidak Cocok !"]);
      $data['password'] = $password;
    }
    $this->db->transStart();
    $this->userModel->save($data);
    $this->db->transComplete();
    if($this->db->transStatus()){
      if($user->id == session()->get('id')){
        $dataSess = [
          'email' => $email,
          'username' => $username,
          'name' => $name,
        ];
        session()->set($dataSess);
      }
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal","error"=>$this->db->error()]);
    }
  }

  public function getUserProfileGroup(){
    $userGroups = $this->userModel->getGroup(session()->get('id'));
    // if(count($userGroups) <= 1) return $this->response->setJSON(["result"=>0,"message"=>"Anda hanya memiliki 1 hak akses"]);
    return $this->response->setJSON(["result"=>1,"group"=>$userGroups]);
  }

  public function switchUserProfileGroup(){
    $id = $this->request->getPost('id');
    $userGroups = $this->userModel->getGroup(session()->get('id'));
    $userGroupIds = array_column((array) $userGroups,'id');
    if($id != 'all'){
      if(!in_array($id,$userGroupIds)) return $this->response->setJSON(["result"=>0,"message"=>"Anda tidak memiliki akses"]);
      $userGroupIds = $id;
    }
    $roles = $this->groupModel->getRole($userGroupIds);
    $menus = $this->groupModel->getMenu($userGroupIds);
    $this->template->buildCleanTree($menus);
    $dataSess = [
      'roles' => array_column($roles,'code'),
      'menus' => $menus,
    ];
    session()->set($dataSess);
    return $this->response->setJSON(["result"=>1]);
  }
}