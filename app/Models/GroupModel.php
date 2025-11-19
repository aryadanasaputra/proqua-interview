<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model{
  protected $table = 'group';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';
  protected $useSoftDeletes = false;
  protected $protectFields = true;
  protected $allowedFields = [
    'id',
    'name',
    'notes',
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
  protected $beforeInsert = ['addCreatedBy'];
  protected $afterInsert = [];
  protected $beforeUpdate = ['addUpdatedBy'];
  protected $afterUpdate = [];
  protected $beforeFind = [];
  protected $afterFind = [];
  protected $beforeDelete = [];
  protected $afterDelete = [];

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

  public function getGroup($param=[]){
    if(!empty($param['search'])){
      $search = $param['search'];
      $this->groupStart();
        $this->like('group.name',$search);
        $this->orLike('group.notes',$search);
      $this->groupEnd();
    }
    if(!empty($param['ordered_field'])){
      $orderedField = $param['ordered_field'];
      $orderedSort = $param['ordered_sort'] ?? 'asc';
      $this->orderBy($orderedField, $orderedSort);
    }
    $this->orderBy('group.id','asc');
    return $this;
  }

  public function getRole($groupId){
    $builder = $this->db->table('group_role');
    $builder->join('role','role.id=group_role.role_id');
    $builder->distinct();
    $builder->select([
      'role.id',
      'role.code',
    ]);
    if(is_array($groupId)){
      $builder->whereIn('group_role.group_id',$groupId);
    }else{
      $builder->where('group_role.group_id',$groupId);
    }
    return $builder->get()->getResult();
  }

  public function getMenu($groupId){
    $builder = $this->db->table('menu');
    $builder->join('role','role.id=menu.role_id','left');
    $builder->join('group_role','group_role.role_id=role.id','left');
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
      if(is_array($groupId)){
        $builder->whereIn('group_role.group_id',$groupId);
      }else{
        $builder->where('group_role.group_id',$groupId);
      }
      $builder->orWhere("menu.role_id IS NULL",null,false);
    $builder->groupEnd();
    $builder->orderBy('menu.code','asc');
    return $builder->get()->getResult();
  }
}