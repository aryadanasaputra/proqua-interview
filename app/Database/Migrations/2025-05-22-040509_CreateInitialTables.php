<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInitialTables extends Migration
{
  public function up()
  {
    // Tabel: group
    $this->forge->addField([
      'id'         => ['type' => 'INT', 'auto_increment' => true],
      'name'       => ['type' => 'VARCHAR', 'constraint' => 255],
      'notes'      => ['type' => 'TEXT'],
      'isactive'   => ['type' => 'TINYINT', 'constraint' => 1],
      'created_by' => ['type' => 'INT', 'null' => true],
      'created_at' => ['type' => 'DATETIME', 'null' => true],
      'updated_by' => ['type' => 'INT', 'null' => true],
      'updated_at' => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('group');

    // Tabel: role
    $this->forge->addField([
      'id'        => ['type' => 'INT', 'auto_increment' => true],
      'parent_id' => ['type' => 'INT', 'null' => true],
      'code'      => ['type' => 'VARCHAR', 'constraint' => 100],
      'name'      => ['type' => 'VARCHAR', 'constraint' => 255],
      'order'     => ['type' => 'VARCHAR', 'constraint' => 100],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('code');
    $this->forge->addForeignKey('parent_id', 'role', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('role');

    // Tabel: group_role
    $this->forge->addField([
      'id'       => ['type' => 'INT', 'auto_increment' => true],
      'group_id' => ['type' => 'INT'],
      'role_id'  => ['type' => 'INT'],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('group_id', 'group', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('role_id', 'role', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('group_role');

    // Tabel: user
    $this->forge->addField([
      'id'         => ['type' => 'INT', 'auto_increment' => true],
      'username'   => ['type' => 'VARCHAR', 'constraint' => 255],
      'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
      'name'       => ['type' => 'VARCHAR', 'constraint' => 255],
      'email'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
      'isactive'   => ['type' => 'TINYINT', 'constraint' => 1],
      'last_login' => ['type' => 'DATETIME', 'null' => true],
      'created_by' => ['type' => 'INT', 'null' => true],
      'created_at' => ['type' => 'DATETIME', 'null' => true],
      'updated_by' => ['type' => 'INT', 'null' => true],
      'updated_at' => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('username');
    $this->forge->createTable('user');

    // Tabel: user_group
    $this->forge->addField([
      'id'       => ['type' => 'INT', 'auto_increment' => true],
      'user_id'  => ['type' => 'INT'],
      'group_id' => ['type' => 'INT'],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('group_id', 'group', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('user_group');

    // Tabel: log_login
    $this->forge->addField([
      'id'      => ['type' => 'INT', 'auto_increment' => true],
      'user_id' => ['type' => 'INT'],
      'tanggal' => ['type' => 'TIMESTAMP', 'null' => true],
      'ip'      => ['type' => 'VARCHAR', 'constraint' => 20],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('log_login');
    $this->db->query("ALTER TABLE `log_login` MODIFY `tanggal` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

    // Tabel: menu
    $this->forge->addField([
      'id'            => ['type' => 'INT', 'auto_increment' => true],
      'role_id'       => ['type' => 'INT', 'null' => true],
      'parent_id'     => ['type' => 'INT', 'null' => true],
      'code'          => ['type' => 'VARCHAR', 'constraint' => 100],
      'name'          => ['type' => 'VARCHAR', 'constraint' => 255],
      'action'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
      'action_active' => ['type' => 'TEXT', 'null' => true],
      'icon'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
      'isactive'      => ['type' => 'TINYINT', 'constraint' => 1],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('code');
    $this->forge->addForeignKey('role_id', 'role', 'id');
    $this->forge->addForeignKey('parent_id', 'menu', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('menu');
  }

  public function down()
  {
    $this->forge->dropTable('menu');
    $this->forge->dropTable('log_login');
    $this->forge->dropTable('user_group');
    $this->forge->dropTable('user');
    $this->forge->dropTable('group_role');
    $this->forge->dropTable('role');
    $this->forge->dropTable('group');
  }
}
