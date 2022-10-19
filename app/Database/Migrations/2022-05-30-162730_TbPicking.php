<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbPicking extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 225,
                'auto_increment' => true,
            ],
            'id_basket' => [
                'type' => 'varchar',
                'constraint' => 17,
            ],
            'assign' => [
                'type' => 'varchar',
                'constraint' => 225,
<<<<<<< HEAD
                'default'   => '-',
                'null'      => true,
=======
                'null' => true
>>>>>>> main
            ],
            'Item_id' => [
                'type' => 'varchar',
                'constraint' => 225,
<<<<<<< HEAD
                'default'   => '001'
=======
                'default'   => 1,
                'null' => true,
>>>>>>> main
            ],
            'Item_detail' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'qty' => [
                'type' => 'int',
                'constraint' => 50,
            ],
            'quantity_pick' => [
                'type' => 'int',
                'constraint' => 50,
            ],
            'status' => [
                'type' => 'int',
                'constraint' => 225,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ]

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_picking');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_picking');
    }
}