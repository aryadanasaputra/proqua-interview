<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
  protected $table = 'user';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = false;
  protected $protectFields = true;
  protected $allowedFields = [
    'id',
    'username',
    'password',
    'name',
    'email',
    'isactive',

    'created_by',
    'updated_by',
  ];

  protected bool $allowEmptyInserts = false;
  protected bool $updateOnlyChanged = true;

  protected array $casts = [];
  protected array $castHandlers = [];

  /** Dates */
  protected $useTimestamps = true;
  protected $dateFormat = 'datetime';
  protected $createdField = 'created_at';
  protected $updatedField = 'updated_at';

  /** Validation */
  protected $validationRules = [];
  protected $validationMessages = [];
  protected $skipValidation = false;
  protected $cleanValidationRules = true;

  /** Callbacks */
  protected $allowCallbacks = true;
  protected $beforeInsert = ['hashPassword','addCreatedBy'];
  protected $afterInsert = [];
  protected $beforeUpdate = ['hashPassword','addUpdatedBy'];
  protected $afterUpdate = [];
  protected $beforeFind = [];
  protected $afterFind = [];
  protected $beforeDelete = [];
  protected $afterDelete = [];

  protected function hashPassword(array $data){
    if(!empty($data['data']['password'])){
      $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
    }
    return $data;
  }

  protected function addCreatedBy(array $data){
    if(session()->has('id')){
      $data['data']['created_by'] = session()->get('id');
    }
    return $data;
  }

  protected function addUpdatedBy(array $data){
    if(session()->has('id')){
      $data['data']['updated_by'] = session()->get('id');
    }
    return $data;
  }

  public function getUser($param=[]){
    /**
     * user_group
     */
    $builder = $this->db->table('user_group');
    $builder->join('group','group.id = user_group.group_id','LEFT');
    $builder->select([
      'user_group.user_id',
      'GROUP_CONCAT(group.id) group_ids',
      "GROUP_CONCAT(group.name SEPARATOR ';') group_names",
      "GROUP_CONCAT(group.notes SEPARATOR ';') group_notes",
    ]);
    $builder->groupBy('user_group.user_id');
    $userGroup = $builder->getCompiledSelect();
    
    $this->join("($userGroup) user_group",'user_group.user_id = user.id','LEFT');
    $this->select([
      'user.id',
      'user.username',
      // 'user.password',
      'user.name',
      'user.email',
      'user.isactive',
      'user.last_login',
      'user_group.group_ids',
      'user_group.group_names',
      'user_group.group_notes',
    ]);
    if(!empty($param['search'])){
      $search = $param['search'];
      $this->groupStart();
      $this->like("user.name",$search);
      $this->orLike("user.username",$search);
      $this->orLike("user.email",$search);
      $this->orLike("user_group.group_names",$search);
      $this->groupEnd();
    }
    if(!empty($param['ordered_field'])){
      $orderedField = $param['ordered_field'];
      $orderedSort = $param['ordered_sort'] ?? 'asc';
      $this->orderBy($orderedField, $orderedSort);
    }
    $this->orderBy('user.id','asc');
    return $this;
  }

  public function getGroup($userId){
    $builder = $this->db->table('user_group');
    $builder->join('group','group.id = user_group.group_id','LEFT');
    $builder->select([
      'group.id',
      'group.name',
      'group.notes',
    ]);
    $builder->where('user_group.user_id',$userId);
    return $builder->get()->getResult();
  }

  public function getRole($userId){
    $builder = $this->db->table('group_role');
    $builder->join('user_group','user_group.group_id=group_role.group_id');
    $builder->join('group','group.id=group_role.group_id AND group.isactive=1');
    $builder->join('role','role.id=group_role.role_id');
    $builder->distinct();
    $builder->select([
      'role.id',
      'role.code',
    ]);
    $builder->where('user_group.user_id',$userId);
    return $builder->get()->getResult();
  }

  public function getMenu($userId){
    $builder = $this->db->table('menu');
    $builder->join('role','role.id=menu.role_id','left');
    $builder->join('group_role','group_role.role_id=role.id','left');
    $builder->join('user_group','user_group.group_id=group_role.group_id','left');
    $builder->distinct();
    $builder->select([
      'menu.id',
      'menu.role_id',
      'menu.parent_id',
      'menu.code',
      'menu.name',
      'menu.action',
      'menu.action_active',
      'menu.icon',
      '(CASE WHEN menu.action IS NULL THEN 1 ELSE 0 END) isparent',
    ]);
    $builder->where('menu.isactive',1);
    $builder->groupStart();
      $builder->where('user_group.user_id',$userId);
      $builder->orWhere("menu.role_id IS NULL",null,false);
    $builder->groupEnd();
    $builder->orderBy('menu.code','asc');
    return $builder->get()->getResult();
  }
}