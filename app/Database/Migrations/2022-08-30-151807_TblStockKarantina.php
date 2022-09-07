<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblStockKarantina extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'item_id' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'item_detail' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'qty' => [
                'type' => 'int',
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
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ]

        ]);
        $this->forge->addKey('item_id', true);
        $this->forge->createTable('tbl_stockkarantina');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_stockkarantina');
    }
}