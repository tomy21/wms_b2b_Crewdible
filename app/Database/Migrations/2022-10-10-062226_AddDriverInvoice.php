<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDriverInvoice extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_invoice', [
            'driver' => [
                'type'           => 'varchar',
                'constraint'     => '255',
                'after'          => 'assign'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_invoice', 'driver');
    }
}