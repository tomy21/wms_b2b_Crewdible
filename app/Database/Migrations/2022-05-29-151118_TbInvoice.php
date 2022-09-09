<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbInvoice extends Migration
{
    public function up()
    {
        $this->forge->addField([


            'id' => [
                'type' => 'varchar',
                'constraint' => 225,
                'auto_increment' => true,
            ],
            'Order_id' => [
                'type' => 'varchar',
                'constraint' => 225,
            ],
            'Item_id' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
                'default'   => 1,
            ],
            'Item_detail' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'quantity' => [
                'type' => 'int',
                'constraint' => 50,
                'null' => TRUE,
                'default'   => 1

            ],
            'volume' => [
                'type' => 'int',
                'constraint' => 50,
                'null'  => true
            ],
            'Vehicle_tag' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null'  => true
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
            'Amount' => [
                'type' => 'int',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'Note' => [
                'type' => 'text',
                'null' => true,
                'null' => TRUE,
            ],
            'stock_location' => [
                'type' => 'varchar',
                'constraint' => 225,
                'null' => TRUE,
            ],
            'slot' => [
                'type' => 'int',
                'constraint' => 225,
                'default'   => '0'
            ],
            'status' => [
                'type' => 'int',
                'constraint' => 225,
                'default'   => '1'
            ],
            'id_basket' => [
                'type' => 'int',
                'constraint' => 225,
                'default'   => '0'
            ],
            'assign' => [
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
        $this->forge->createTable('tbl_invoice');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_invoice');
    }
}