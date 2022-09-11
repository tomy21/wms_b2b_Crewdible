<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblWarehouse extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id_warehouse' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'warehouse_name' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],

        ]);
        $this->forge->addKey('id_warehouse', true);
        $this->forge->createTable('tbl_warehouse');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_warehouse');
    }
}