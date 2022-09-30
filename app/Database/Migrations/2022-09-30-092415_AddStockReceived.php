<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStockReceived extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_stock', [
            'qty_received' => [
                'type'           => 'INT',
                'constraint'     => '255',
                'after'          => 'quantity_good'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_stock', 'quantity_good');
    }
}