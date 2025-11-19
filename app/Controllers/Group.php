<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\RoleModel;
use App\Controllers\BaseController;

class Group extends BaseController {
  protected $groupModel;
  protected $roleModel;
  
  public function __construct(){
    $this->groupModel = model(GroupModel::class);
    $this->roleModel = model(RoleModel::class);
  }

  public function index(){
    $param = [
      'search' => $this->request->getGet('search'),
      'ordered_field' => $this->request->getGet('ordered_field'),
      'ordered_sort' => $this->request->getGet('ordered_sort'),
    ];
    $viewData['groups'] = $this->groupModel->getGroup($param)->findAll();
    if($this->request->isAJAX()){
      return $this->view('group/view_group_ajax', $viewData);
    }else{
      $roles = $this->roleModel->findAll();
      $roleParentIds = array_unique(array_column($roles,'parent_id'));
      $roles = array_map(function($role) use($roleParentIds){
        $isparent = 0;
        if(in_array($role->id,$roleParentIds)) $isparent = 1;
        $role->isparent = $isparent;
        return $role;
      }, $roles);
      $viewData['roles'] = $this->template->buildTree($roles);
      return $this->view('group/view_group', $viewData);
    }
  }

  public function add(){
    $name = $this->request->getPost('name');
    $notes = $this->request->getPost('notes');
    $isactive = (bool) $this->request->getPost('isactive');
    $roleIds = (array) $this->request->getPost('role_id');
    $data = [
      'name' => $name,
      'notes' => $notes,
      'isactive' => $isactive,
    ];
    $this->db->transStart();
    $this->groupModel->save($data);
    $groupId = $this->groupModel->insertID();

    /** Group Role */
    if($roleIds){
      $groupRoleData = [];
      foreach($roleIds as $roleId){
        $groupRoleData[] = [
          'group_id' => $groupId,
          'role_id' => $roleId,
        ];
      }
      $this->db->table('group_role')->insertBatch($groupRoleData);
    }

    $this->db->transComplete();
    if($this->db->transStatus()){
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal","error"=>$this->db->error()]);
    }
  }

  public function getData($id){
    $group = $this->groupModel->select([
      'id',
      'name',
      'notes',
      'isactive',
    ])->find($id);
    $groupRoles = $this->groupModel->getRole($group->id);
    $group->role_ids = array_column($groupRoles,'id');
    return $this->response->setJSON(["result"=>1,"group"=>$group]);
  }

  public function edit($id){
    $group = $this->groupModel->find($id);
    if(empty($group)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak ditemukan !"]);
    }
    $name = $this->request->getPost('name');
    $notes = $this->request->getPost('notes');
    $isactive = (bool) $this->request->getPost('isactive');
    $roleIds = (array) $this->request->getPost('role_id');
    $data = [
      'id' => $group->id,
      'name' => $name,
      'notes' => $notes,
      'isactive' => $isactive,
    ];

    $this->db->transStart();
    $data['id'] = $group->id;
    $this->groupModel->save($data);
    /** Group Role */
    $RoleGroups = $this->groupModel->getRole($group->id);
    $groupRoleInsertData = [];
    $roleInsertIds = array_diff($roleIds, array_column($RoleGroups, 'id'));
    $roleDeleteIds = array_diff(array_column($RoleGroups, 'id'), $roleIds);
    foreach($roleInsertIds as $roleInsertId){
      $groupRoleInsertData[] = [
        'group_id' => $group->id,
        'role_id' => $roleInsertId,
      ];
    }
    if($groupRoleInsertData){
      $this->db->table('group_role')->insertBatch($groupRoleInsertData);
    }
    if($roleDeleteIds){
      $this->db->table('group_role')->where('group_id',$group->id)->whereIn('role_id',$roleDeleteIds)->delete();
    }
    $this->db->transComplete();
    if($this->db->transStatus()){
      return $this->response->setJSON(["result"=>1]);
    }else{
      return $this->response->setJSON(["result"=>0,"message"=>"Gagal","error"=>$this->db->error()]);
    }
  }

  public function delete($id){
    $group = $this->groupModel->find($id);
    if(empty($group)){
      return $this->response->setJSON(["result"=>0,"message"=>"data tidak ditemukan !"]);
      return;
    }
    $delete = $this->groupModel->delete($group->id);
    if($delete) return $this->response->setJSON(["result"=>1]);
  }
  
}