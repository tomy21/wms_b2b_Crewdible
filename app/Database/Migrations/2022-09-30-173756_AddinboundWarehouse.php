<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddinboundWarehouse extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_inbound', [
            'warehouse' => [
                'type'           => 'varchar',
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
