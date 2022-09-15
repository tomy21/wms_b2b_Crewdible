<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWarehouseStock extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_stock', [
            'warehouse' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'after'          => 'Item_id'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_stock', 'warehouse');
    }
}