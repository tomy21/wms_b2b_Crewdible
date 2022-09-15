<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWarehousePicking extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_picking', [
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
        $this->forge->dropColumn('tbl_picking', 'warehouse');
    }
}
