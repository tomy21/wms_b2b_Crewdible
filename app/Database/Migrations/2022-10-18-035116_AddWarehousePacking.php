<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWarehousePacking extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_packing', [
            'warehouse' => [
                'type'           => 'varchar',
                'constraint'     => '255',
                'after'          => 'assign'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_packing', 'warehouse');
    }
}
