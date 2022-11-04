<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnListHandover extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_listhandover', [
            'warehouse' => [
                'type'           => 'varchar',
                'constraint'     => '255',
                'after'          => 'id_handover'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_listhandover', 'warehouse');
    }
}