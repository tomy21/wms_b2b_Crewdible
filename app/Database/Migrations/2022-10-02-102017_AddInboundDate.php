<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInboundDate extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_inbound', [
            'estimate_date' => [
                'type'           => 'varchar',
                'constraint'     => '255',
                'after'          => 'status'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_inbound', 'estimate_date');
    }
}