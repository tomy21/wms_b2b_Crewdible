<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnCodeWh extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_warehouse', [
            'warehouse_code' => [
                'type'           => 'varchar',
                'constraint'     => '11',
                'after'          => 'warehouse_name'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_warehouse', 'warehouse_code');
    }
}
