<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbPacking extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'order_id' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'list' => [
                'type' => 'longtext',
            ],
            'foto' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'assign' => [
                'type' => 'varchar',
                'constraint' => 225,
                'default'   => '-',
                'null' => true,
            ],
            'Status' => [
                'type' => 'varchar',
                'constraint' => 225,
                'default'   => 0,
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
        $this->forge->createTable('tbl_packing');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_packing');
    }
}