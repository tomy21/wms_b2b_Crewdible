<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDriverOrder extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_invoice', [
            'driver' => [
                'type'           => 'varchar',
                'constraint'     => '255',
                'after'          => 'id_basket'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_invoice', 'driver');
    }
}