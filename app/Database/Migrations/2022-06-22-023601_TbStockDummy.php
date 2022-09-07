<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbStockDummy extends Migration
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
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ]

        ]);
        $this->forge->addKey('Item_id', true);
        $this->forge->createTable('tbl_stockDummy');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_stockDummy');
    }
}