<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWarehousePO extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_po', [
            'warehouse' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'after'          => 'no_Po'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_po', 'warehouse');
    }
}