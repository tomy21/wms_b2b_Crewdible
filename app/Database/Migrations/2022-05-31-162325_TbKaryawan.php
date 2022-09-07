<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbKaryawan extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id_user' => [
                'type' => 'int',
                'constraint' => 225,
                'auto_increment' => true,
            ],
            'nama_user' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'level' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'warehouse' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'status_kar' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ]

        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('tbl_karyawan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_karyawan');
    }
}