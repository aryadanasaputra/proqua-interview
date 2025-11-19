<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupModel;
use App\Controllers\BaseController;

class User extends BaseController {
  protected $userModel;
  protected $groupModel;
  
  public function __construct(){
    $this->userModel = model(UserModel::class);
    $this->groupModel = model(GroupModel::class);
  }

  public function index(){
    $param = [
      'search' => $this->request->getGet('search'),
      'ordered_field' => $this->request->getGet('ordered_field'),
      'ordered_sort' => $this->request->getGet('ordered_sort'),
    ];
    $limit = 10;
    $viewData['users'] = $users = $this->userModel->getUser($param)->paginate($limit);
    $viewData['pager'] = $this->userModel->pager;
    $viewData['startNumber'] = ($this->userModel->pager->getCurrentPage() - 1) * $limit;
    if($this->request->isAJAX()){
      return $this->view('user/view_user_ajax', $viewData);
    }else{
      $viewData['groups'] = $this->groupModel->findAll();
      return $this->view('user/view_user', $viewData);
    }
  }

  public function add(){
    $name = $this->request->getPost('name');
    $username = $this->request->getPost('username');
    $email = $this->request->getPost('email');
    $groupIds = (array) $this->request->getPost('group_id');
    $password = $this->request->getPost('password') ?? '';
    $rePassword = $this->request->getPost('re_password');
    $isactive = (bool) $this->request->getPost('isactive');
    $userExist = $this->userModel->where('username',$username)->first();
    if(!empty($userExist)){
      return $this->response->setJSON(["result"=>0,"message"=>"Username sudah digunakan, gunakan username lain !"]);
    }
    if($rePassword != $password){
      return $this->response->setJSON(["result"=>0,"message"=>"Ketik ulang sandi tidak sesuai"]);
    }
    $data = [
      'name' => $name,
      'username' => $username,
      'email' => $email,
      'password' => $password,
      'isactive' => $isactive,
    ];
    $this->db->transStart();
    $this->userModel->save($data);
    $userId = $this->userModel->insertID();
    /** User Group */
    $this->_syncUserGroup(userId:$userId, groupIds:$groupIds, isNew:true);
    $this->db->transComplete();
    if($this->db->transStatus()){
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal","error"=>$this->db->error()]);
    }
  }

  public function getData($id){
    $user = $this->userModel
      ->select([
        'id',
        'name',
        'username',
        'email',
        'isactive',
      ])
      ->find($id);
    $userGroups = $this->userModel->getGroup($user->id);
    $user->group_ids = array_column($userGroups,'id');
    return $this->response->setJSON(["result"=>1,"user"=>$user]);
  }

  public function edit($id){
    $user = $this->userModel->find($id);
    if(empty($user)) return $this->response->setJSON(["result"=>0,"message"=>"Data tidak ditemukan !"]);
    $data = $this->request->getPost();
    $name = $this->request->getPost('name');
    $username = $this->request->getPost('username');
    $email = $this->request->getPost('email');
    $groupIds = (array) $this->request->getPost('group_id');
    $isactive = (bool) $this->request->getPost('isactive');
    $isChangePassword = $this->request->getPost('is_change_password');
    $userExist = $this->userModel
      ->where('id != ',$user->id)
      ->where('username',$username)
      ->first();
    if(!empty($userExist)) return $this->response->setJSON(["result"=>0,"message"=>"Username sudah digunakan, gunakan username lain !"]);
    $data = [
      'name' => $name,
      'username' => $username,
      'email' => $email,
    ];
    if($user->id != session()->get('id')){
      $data['isactive'] = $isactive;
    }
    if($isChangePassword){
      $password = $this->request->getPost('password') ?? '';
      $rePassword = $this->request->getPost('re_password');
      if($password != $rePassword){
        return $this->response->setJSON(["result"=>0,"message"=>"Ulangi Sandi Tidak Cocok !"]);
      }
      $data['password'] = $password;
    }
    $this->db->transStart();
    $this->db->table('user')->where('id',$user->id)->update($data);
    /** User Group */
    $this->_syncUserGroup(userId:$user->id, groupIds:$groupIds);
    $this->db->transComplete();
    if($this->db->transStatus()){
      if($user->id == session()->get('id')){
        $dataSess = [
          'username' => $username,
          'email' => $email,
          'name' => $name,
        ];
        session()->set($dataSess);
      }
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal","error"=>$this->db->error()]);
    }
  }

  private function _syncUserGroup($userId, array $groupIds = [], bool $isNew = false){
    if(!$groupIds) return;
    $insertDatas = [];

    if(!$isNew){
      $userGroups = $this->userModel->getGroup($userId);
      $userGroupIds = array_column($userGroups,'id');
    }else{
      $userGroupIds = [];
    }
    
    $insertGroupIds = array_diff($groupIds,$userGroupIds);
    $deleteGroupIds = array_diff($userGroupIds,$groupIds);
    foreach($insertGroupIds as $insertGroupId){
      $insertDatas[] = [
        'user_id' => $userId,
        'group_id' => $insertGroupId,
      ];
    }
    if(!empty($insertDatas)) $this->db->table('user_group')->insertBatch($insertDatas);
    if(!empty($deleteGroupIds)) $this->db->table('user_group')->where('user_id',$userId)->whereIn('group_id',$deleteGroupIds)->delete();
  }

  public function delete($id){
    if($id == session()->get('id')){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak dapat dihapus !"]);
    }
    $user = $this->userModel->find($id);
    if(empty($user)){
      return $this->response->setJSON(["result"=>0,"message"=>"Data tidak ditemukan !"]);
    }
    $delete = $this->userModel->delete($user->id);
    if($delete) return $this->response->setJSON(["result"=>1]);
  }

}