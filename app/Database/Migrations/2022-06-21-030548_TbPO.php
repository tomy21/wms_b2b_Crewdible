<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbPO extends Migration
{
    public function up()
    {
        $this->forge->addField([


            'no_Po' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'driver' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'noplat' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'foto' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'tandatangan' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'jumlah_Item' => [
                'type' => 'int',
                'constraint' => 100,
            ],
            'quantity_item' => [
                'type' => 'int',
                'constraint' => 100,
            ],
            'quantity_count' => [
                'type' => 'int',
                'constraint' => 100,
            ],
            'selisih' => [
                'type' => 'int',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'int',
                'constraint' => 100,
            ],
            'waktu_datang' => [
                'type' => 'datetime',
                'null' => TRUE,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_po');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_po');
    }
}