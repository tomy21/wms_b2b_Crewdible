<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogInbound extends Migration
{
    public function up()
    {
        $this->forge->addField([

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
                'type' => 'int',
                'constraint' => 225,
            ],
            'stock_good' => [
                'type' => 'int',
                'constraint' => 225,
            ],
            'stock_bad' => [
                'type' => 'int',
                'constraint' => 225,
            ],
            'selisih' => [
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
        $this->forge->createTable('tbl_loginbound');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_loginbound');
    }
}