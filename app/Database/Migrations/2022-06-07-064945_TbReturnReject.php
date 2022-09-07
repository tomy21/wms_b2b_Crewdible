<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbReturnReject extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Order_id' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'Receive' => [
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
            'qty' => [
                'type' => 'int',
                'constraint' => 50,
            ],
            'Status' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'Reason' => [
                'type' => 'text',
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

        $this->forge->createTable('tbl_returnReject');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_returnReject');
    }
}