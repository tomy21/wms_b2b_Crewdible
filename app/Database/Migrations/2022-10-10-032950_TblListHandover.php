<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblListHandover extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'int',
                'constraint' => 16,
                'auto_increment' => true,
            ],
            'id_handover' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'order_id' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'driver' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'nama_penerima' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'alamat' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'no_tlp' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'status' => [
                'type' => 'int',
                'constraint' => 2,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_listhandover');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_listhandover');
    }
}