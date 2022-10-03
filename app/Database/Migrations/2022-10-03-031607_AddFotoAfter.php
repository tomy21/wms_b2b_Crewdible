<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoAfter extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_packing', [
            'foto_after' => [
                'type'           => 'varchar',
                'constraint'     => '255',
                'after'          => 'foto'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_packing', 'foto_after');
    }
}