<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblManifestHandover extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id_handover' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'listItem' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'driver' => [
                'type' => 'varchar',
                'constraint' => 225,
                'default'   => 0,
            ],
            'foto' => [
                'type' => 'varchar',
                'constraint' => 225,
                'default'   => 0,
            ],
            'tandatangan' => [
                'type' => 'varchar',
                'constraint' => 225,
                'default'   => 0,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ]

        ]);
        $this->forge->addKey('id_handover', true);
        $this->forge->createTable('tbl_handover');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_handover');
    }
}