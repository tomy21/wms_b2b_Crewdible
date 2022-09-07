<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblMasteritem extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'item_id' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
                'default'   => 1,
            ],
            'vendor_id' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
                'default'   => 1,
            ],
            'item_name' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'volume' => [
                'type' => 'int',
                'constraint' => 50,
                'null' => TRUE,
                'default'   => 1
            ],
            'status' => [
                'type' => 'varchar',
                'constraint' => 225,
                'default'   => 'new'
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
        $this->forge->addKey('item_id', true);
        $this->forge->createTable('tbl_masteritem');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_masteritem');
    }
}