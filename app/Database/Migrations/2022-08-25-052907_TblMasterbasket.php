<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblMasterbasket extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id_basket' => [
                'type' => 'varchar',
                'constraint' => 17,
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
                'default'   => 0,
            ],
            'kap_order' => [
                'type' => 'int',
                'constraint' => 225,
                'null' => TRUE,
                'default'   => 0,
            ],
            'status' => [
                'type' => 'int',
                'constraint' => 225,
                'null' => TRUE,
                'default'   => 0,
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
        $this->forge->addKey('id_basket', true);
        $this->forge->createTable('tbl_masterbasket');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_masterbasket');
    }
}