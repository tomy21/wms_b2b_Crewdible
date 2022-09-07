<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbUser extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id_user' => [
                'type' => 'int',
                'constraint' => 225,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'email' => [
                'type' => 'int',
                'constraint' => 50,
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'level' => [
                'type' => 'varchar',
                'constraint' => 225,
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
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('tb_user');
    }

    public function down()
    {
        $this->forge->dropTable('tb_user');
    }
}