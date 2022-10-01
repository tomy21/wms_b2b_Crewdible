<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddidStock extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_stock', [
            'sku' => [
                'type'           => 'varchar',
                'constraint'     => '255',
                'after'          => 'Item_id'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_stock', 'sku');
    }
}