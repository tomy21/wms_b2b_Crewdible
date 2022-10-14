<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDriverOrder extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_order', [
            'driver' => [
                'type'           => 'varchar',
                'constraint'     => '255',
                'after'          => 'Assign'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_order', 'driver');
    }
}