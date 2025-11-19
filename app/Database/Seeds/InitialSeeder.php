<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // USER
        $this->db->table('user')->insertBatch([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$12$UbjZrXswyg9aJeY5vQI.fOcJspi/yIa6HtyeDvR5m0AykEW76LWci',
                'name' => 'Administrator',
                'email' => '',
                'isactive' => 1,
                'last_login' => '2025-11-19 23:04:54',
            ],
            [
                'id' => 2,
                'username' => 'admisi',
                'password' => '$2y$10$ZYCGDUSBj32kshXi9O0/lOKl2Nrq2QeihepWfQt1aZa4eVHMnUTjm',
                'name' => 'Admisi',
                'email' => '',
                'isactive' => 1,
                'created_by' => 1,
                'created_at' => '2025-11-19 23:04:25',
            ],
            [
                'id' => 3,
                'username' => 'perawat',
                'password' => '$2y$10$qBzbq29IAn7P9L3plhlK1.TzMTxI/TEO.gc0kV0ine3htjYkUZBWe',
                'name' => 'Perawat',
                'email' => '',
                'isactive' => 1,
                'created_by' => 1,
                'created_at' => '2025-11-19 23:04:44',
            ],
        ]);

        // GROUP
        $this->db->table('group')->insertBatch([
            ['id' => 1, 'name' => 'Superadmin', 'notes' => 'Administrator dapat mengakses seluruh akses (all control)', 'isactive' => 1, 'updated_by' => 1, 'updated_at' => '2025-11-19 22:53:56'],
            ['id' => 2, 'name' => 'Admisi', 'notes' => '', 'isactive' => 1, 'created_by' => 1, 'created_at' => '2025-11-19 22:46:10', 'updated_by' => 1, 'updated_at' => '2025-11-19 22:54:02'],
            ['id' => 3, 'name' => 'Perawat', 'notes' => '', 'isactive' => 1, 'created_by' => 1, 'created_at' => '2025-11-19 22:46:17', 'updated_by' => 1, 'updated_at' => '2025-11-19 22:54:10'],
        ]);

        // ROLE
        $this->db->table('role')->insertBatch([
            ['id'=>1,'parent_id'=>null,'code'=>'user','name'=>'Pengguna','order'=>'009'],
            ['id'=>2,'parent_id'=>null,'code'=>'group','name'=>'Group','order'=>'010'],
            ['id'=>3,'parent_id'=>null,'code'=>'pasien','name'=>'Pasien','order'=>'001'],
            ['id'=>4,'parent_id'=>null,'code'=>'pendaftaran','name'=>'Pendaftaran','order'=>'003'],
            ['id'=>5,'parent_id'=>null,'code'=>'kunjungan','name'=>'Kunjungan','order'=>'005'],
            ['id'=>6,'parent_id'=>null,'code'=>'asesmen','name'=>'Asesmen','order'=>'007'],
            ['id'=>7,'parent_id'=>3,'code'=>'crud_pasien','name'=>'CRUD','order'=>'002'],
            ['id'=>8,'parent_id'=>4,'code'=>'crud_pendaftaran','name'=>'CRUD','order'=>'004'],
            ['id'=>9,'parent_id'=>5,'code'=>'crud_kunjungan','name'=>'CRUD','order'=>'006'],
            ['id'=>10,'parent_id'=>6,'code'=>'crud_asesmen','name'=>'CRUD','order'=>'008'],
        ]);

        // group_role
        $this->db->table('group_role')->insertBatch([
            ['id'=>1,'group_id'=>1,'role_id'=>1],
            ['id'=>2,'group_id'=>1,'role_id'=>2],
            ['id'=>3,'group_id'=>1,'role_id'=>3],
            ['id'=>4,'group_id'=>1,'role_id'=>4],
            ['id'=>5,'group_id'=>1,'role_id'=>5],
            ['id'=>6,'group_id'=>1,'role_id'=>6],
            ['id'=>7,'group_id'=>2,'role_id'=>4],
            ['id'=>8,'group_id'=>2,'role_id'=>5],
            ['id'=>9,'group_id'=>1,'role_id'=>7],
            ['id'=>10,'group_id'=>1,'role_id'=>8],
            ['id'=>11,'group_id'=>1,'role_id'=>9],
            ['id'=>12,'group_id'=>1,'role_id'=>10],
            ['id'=>13,'group_id'=>2,'role_id'=>8],
            ['id'=>14,'group_id'=>2,'role_id'=>9],
            ['id'=>15,'group_id'=>3,'role_id'=>4],
            ['id'=>16,'group_id'=>3,'role_id'=>5],
            ['id'=>17,'group_id'=>3,'role_id'=>6],
            ['id'=>18,'group_id'=>3,'role_id'=>10],
        ]);

        // user_group
        $this->db->table('user_group')->insertBatch([
            ['id'=>1,'user_id'=>1,'group_id'=>1],
            ['id'=>2,'user_id'=>2,'group_id'=>2],
            ['id'=>3,'user_id'=>3,'group_id'=>3],
            ['id'=>4,'user_id'=>1,'group_id'=>2],
            ['id'=>5,'user_id'=>1,'group_id'=>3],
        ]);

        // menu
        $this->db->table('menu')->insertBatch([
            ['id'=>1,'role_id'=>null,'parent_id'=>null,'code'=>'001','name'=>'Home','action'=>'home','action_active'=>'home','icon'=>'fa fa-th-large','isactive'=>1],
            ['id'=>2,'role_id'=>3,'parent_id'=>null,'code'=>'002','name'=>'Pasien','action'=>'pasien','action_active'=>'pasien','isactive'=>1],
            ['id'=>3,'role_id'=>4,'parent_id'=>null,'code'=>'003','name'=>'Pendaftaran','action'=>'pendaftaran','action_active'=>'pendaftaran','isactive'=>1],
            ['id'=>4,'role_id'=>5,'parent_id'=>null,'code'=>'004','name'=>'Kunjungan','action'=>'kunjungan','action_active'=>'kunjungan','isactive'=>1],
            ['id'=>5,'role_id'=>6,'parent_id'=>null,'code'=>'005','name'=>'Asesmen','action'=>'asesmen','action_active'=>'asesmen','isactive'=>1],
            ['id'=>6,'role_id'=>null,'parent_id'=>null,'code'=>'006','name'=>'Sistem','icon'=>'fa fa-cogs','isactive'=>1],
            ['id'=>7,'role_id'=>1,'parent_id'=>6,'code'=>'006.001','name'=>'Pengguna','action'=>'user','action_active'=>'user','icon'=>'fa fa-user-lock','isactive'=>1],
            ['id'=>8,'role_id'=>2,'parent_id'=>6,'code'=>'006.002','name'=>'Group','action'=>'group','action_active'=>'group','icon'=>'fa fa-users-cog','isactive'=>1],
        ]);

        // pasien
        $this->db->table('pasien')->insertBatch([
            ['id'=>5,  'nama'=>'Leanne Graham', 'norm'=>'1', 'alamat'=>'Kulas Light Apt. 556 Gwenborough 92998-3874'],
            ['id'=>6,  'nama'=>'Ervin Howell', 'norm'=>'2', 'alamat'=>'Victor Plains Suite 879 Wisokyburgh 90566-7771'],
            ['id'=>7,  'nama'=>'Clementine Bauch', 'norm'=>'3', 'alamat'=>'Douglas Extension Suite 847 McKenziehaven 59590-4157'],
            ['id'=>8,  'nama'=>'Patricia Lebsack', 'norm'=>'4', 'alamat'=>'Hoeger Mall Apt. 692 South Elvis 53919-4257'],
            ['id'=>9,  'nama'=>'Chelsey Dietrich', 'norm'=>'5', 'alamat'=>'Skiles Walks Suite 351 Roscoeview 33263'],
            ['id'=>10, 'nama'=>'Mrs. Dennis Schulist', 'norm'=>'6', 'alamat'=>'Norberto Crossing Apt. 950 South Christy 23505-1337'],
            ['id'=>11, 'nama'=>'Kurtis Weissnat', 'norm'=>'7', 'alamat'=>'Rex Trail Suite 280 Howemouth 58804-1099'],
            ['id'=>12, 'nama'=>'Nicholas Runolfsdottir V', 'norm'=>'8', 'alamat'=>'Ellsworth Summit Suite 729 Aliyaview 45169'],
            ['id'=>13, 'nama'=>'Glenna Reichert', 'norm'=>'9', 'alamat'=>'Dayna Park Suite 449 Bartholomebury 76495-3109'],
            ['id'=>14, 'nama'=>'Clementina DuBuque', 'norm'=>'10','alamat'=>'Kattie Turnpike Suite 198 Lebsackbury 31428-2261'],
        ]);

        // pendaftaran
        $this->db->table('pendaftaran')->insert([
            'id'=>2, 'pasienid'=>5, 'noregistrasi'=>'ww', 'tglregistrasi'=>'2025-11-19 21:17:00'
        ]);

        // kunjungan
        $this->db->table('kunjungan')->insert([
            'id'=>2, 'pendaftaranpasienid'=>2, 'jeniskunjungan'=>'baru', 'tglkunjungan'=>'2025-11-19 21:29:00'
        ]);

        // asesmen
        $this->db->table('asesmen')->insert([
            'id'=>2, 'kunjunganid'=>2, 'keluhan_utama'=>'aa', 'keluhan_tambahan'=>'aa'
        ]);

        // log_login
        $this->db->table('log_login')->insertBatch([
            ['id'=>1,'user_id'=>1,'tanggal'=>'2025-11-19 10:02:20','ip'=>'::1'],
            ['id'=>2,'user_id'=>1,'tanggal'=>'2025-11-19 12:29:47','ip'=>'::1'],
            ['id'=>3,'user_id'=>1,'tanggal'=>'2025-11-19 16:04:54','ip'=>'::1'],
        ]);
    }
}
