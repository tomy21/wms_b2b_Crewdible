<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addinbound extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_inbound', [
            'qty_received' => [
                'type'           => 'INT',
                'constraint'     => '255',
                'after'          => 'quantity'
            ],
            'status' => [
                'type'           => 'INT',
                'constraint'     => '5',
                'after'          => 'quantity'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_inbound', 'qty_received');
        $this->forge->dropColumn('tbl_inbound', 'status');
    }
}