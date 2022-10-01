<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddinboundQty extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_inbound', [
            'qty_received' => [
                'type'           => 'INT',
                'constraint'     => '255',
                'after'          => 'status'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_inbound', 'qty_received');
    }

}
