<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
  public function run()
  {
    // Matikan FK sementara
    $this->db->query('SET foreign_key_checks = 0');

    // Seed group
    $this->db->table('group')->insert([
      'id' => 1,
      'name' => 'Administrator',
      'notes' => 'Administrator dapat mengakses seluruh akses (all control)',
      'isactive' => 1,
    ]);

    // Seed role
    $this->db->table('role')->insertBatch([
      [
        'id' => 1,
        'parent_id' => null,
        'code' => 'user',
        'name' => 'Pengguna',
        'order' => '001',
      ],
      [
        'id' => 2,
        'parent_id' => null,
        'code' => 'group',
        'name' => 'Group',
        'order' => '002',
      ]
    ]);

    // Seed group_role
    $this->db->table('group_role')->insertBatch([
      ['id' => 1, 'group_id' => 1, 'role_id' => 1],
      ['id' => 2, 'group_id' => 1, 'role_id' => 2],
    ]);

    // Seed user
    $this->db->table('user')->insert([
      'id' => 1,
      'username' => 'admin',
      'password' => password_hash('admin', PASSWORD_BCRYPT),
      'name' => 'Administrator',
      'email' => null,
      'isactive' => 1,
    ]);

    // Seed menu
    $this->db->table('menu')->insertBatch([
      [
        'id' => 1,
        'role_id' => null,
        'parent_id' => null,
        'code' => '001',
        'name' => 'Home',
        'action' => 'home',
        'action_active' => 'home',
        'icon' => 'fa fa-th-large',
        'isactive' => 1
      ],
      [
        'id' => 2,
        'role_id' => null,
        'parent_id' => null,
        'code' => '002',
        'name' => 'Sistem',
        'action' => null,
        'action_active' => null,
        'icon' => 'fa fa-cogs',
        'isactive' => 1
      ],
      [
        'id' => 3,
        'role_id' => 1,
        'parent_id' => 2,
        'code' => '002.001',
        'name' => 'Pengguna',
        'action' => 'user',
        'action_active' => 'user',
        'icon' => 'fa fa-user-lock',
        'isactive' => 1
      ],
      [
        'id' => 4,
        'role_id' => 2,
        'parent_id' => 2,
        'code' => '002.002',
        'name' => 'Group',
        'action' => 'group',
        'action_active' => 'group',
        'icon' => 'fa fa-users-cog',
        'isactive' => 1
      ]
    ]);

    // Seed user_group
    $this->db->table('user_group')->insert([
      'id' => 1,
      'user_id' => 1,
      'group_id' => 1,
    ]);

    // FK back on
    $this->db->query('SET foreign_key_checks = 1');
  }
}
