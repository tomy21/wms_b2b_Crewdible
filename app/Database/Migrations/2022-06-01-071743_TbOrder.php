<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbOrder extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Order_id' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'Drop_name' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Drop_contact' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Drop_address' => [
                'type' => 'text',
                'null' => true,
            ],
            'Drop_city' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Drop_country' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Drop_zipcode' => [
                'type' => 'varchar',
                'constraint' => 5,
                'null' => TRUE,
            ],
            'Drop_latitude' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null'  => true
            ],
            'Drop_longitude' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null'  => true
            ],
            'Transaction_time' => [
                'type' => 'int',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'Drop_date' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Drop_start_time' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Drop_end_time' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Payment_methode' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'NamaDriver' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Vehicle_tag' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'note' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'slot' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'status' => [
                'type' => 'varchar',
                'constraint' => 225,
                'default'   => 'new'
            ],
            'stock_location' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'Assign' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'id_basket' => [
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
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ]

        ]);
        $this->forge->addKey('Order_id', true);
        $this->forge->createTable('tbl_order');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_order');
    }
}