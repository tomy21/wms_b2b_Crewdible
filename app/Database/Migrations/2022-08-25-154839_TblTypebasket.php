<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblTypebasket extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'int',
                'constraint' => 225,
                'auto_increment' => true,
            ],
            'type' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'kapasitas' => [
                'type' => 'int',
                'constraint' => 225,
                'null' => TRUE,
                'default'   => 1,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ]

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_typebasket');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_typebasket');
    }
}