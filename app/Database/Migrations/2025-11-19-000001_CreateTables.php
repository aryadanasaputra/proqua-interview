<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        // TABEL: user
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'username'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'password'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'isactive'    => ['type' => 'TINYINT', 'constraint' => 1],
            'last_login'  => ['type' => 'DATETIME', 'null' => true],
            'created_by'  => ['type' => 'INT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_by'  => ['type' => 'INT', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('user');

        // TABEL: group
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

        // TABEL: role
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'auto_increment' => true],
            'parent_id' => ['type' => 'INT', 'null' => true],
            'code'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'order'     => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey('parent_id');
        $this->forge->createTable('role');

        // TABEL: group_role
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'auto_increment' => true],
            'group_id' => ['type' => 'INT'],
            'role_id'  => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('group_id');
        $this->forge->addKey('role_id');
        $this->forge->createTable('group_role');

        // TABEL: user_group
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'auto_increment' => true],
            'user_id'  => ['type' => 'INT'],
            'group_id' => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('group_id');
        $this->forge->createTable('user_group');

        // TABEL: menu
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
        $this->forge->createTable('menu');

        // TABEL: pasien
        $this->forge->addField([
            'id'     => ['type' => 'INT', 'auto_increment' => true],
            'nama'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'norm'   => ['type' => 'VARCHAR', 'constraint' => 10],
            'alamat' => ['type' => 'TEXT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pasien');

        // TABEL: pendaftaran
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'pasienid'     => ['type' => 'INT'],
            'noregistrasi' => ['type' => 'VARCHAR', 'constraint' => 20],
            'tglregistrasi'=> ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('pasienid');
        $this->forge->createTable('pendaftaran');

        // TABEL: kunjungan
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'auto_increment' => true],
            'pendaftaranpasienid' => ['type' => 'INT'],
            'jeniskunjungan'      => ['type' => 'ENUM', 'constraint' => ['baru', 'lama']],
            'tglkunjungan'        => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('pendaftaranpasienid');
        $this->forge->createTable('kunjungan');

        // TABEL: asesmen
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true],
            'kunjunganid'      => ['type' => 'INT'],
            'keluhan_utama'    => ['type' => 'TEXT'],
            'keluhan_tambahan' => ['type' => 'TEXT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('kunjunganid');
        $this->forge->createTable('asesmen');

        // TABEL: log_login
        $this->forge->addField([
            'id'      => ['type' => 'INT', 'auto_increment' => true],
            'user_id' => ['type' => 'INT'],
            'tanggal' => ['type' => 'TIMESTAMP', 'null' => true],
            'ip'      => ['type' => 'VARCHAR', 'constraint' => 20],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('log_login');
    }

    public function down()
    {
        $this->forge->dropTable('log_login');
        $this->forge->dropTable('asesmen');
        $this->forge->dropTable('kunjungan');
        $this->forge->dropTable('pendaftaran');
        $this->forge->dropTable('pasien');
        $this->forge->dropTable('menu');
        $this->forge->dropTable('user_group');
        $this->forge->dropTable('group_role');
        $this->forge->dropTable('role');
        $this->forge->dropTable('group');
        $this->forge->dropTable('user');
    }
}
