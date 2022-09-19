<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWarehouseInbound extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_inbound', [
            'warehouse' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'after'          => 'nopo'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_inbound', 'warehouse');
    }
}