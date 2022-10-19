<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddListHandoverDate extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_listhandover', [
            'created_at' => [
                'type'           => 'datetime',
                'null'           => TRUE,
                'after'          => 'status'
            ],
            'updated_at' => [
                'type'           => 'datetime',
                'null'           => TRUE,
                'after'          => 'status'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_listhandover', 'created_at');
        $this->forge->dropColumn('tbl_listhandover', 'updated_at');
    }
}