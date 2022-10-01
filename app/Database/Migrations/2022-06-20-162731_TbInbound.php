<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbInbound extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'id',
                'constraint' => 225,
                'auto_increment' => true,
            ],
            'nopo' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'Item_id' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'Item_detail' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'quantity' => [
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_inbound');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_inbound');
    }
}