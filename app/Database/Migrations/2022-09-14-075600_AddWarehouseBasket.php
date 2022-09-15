<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWarehouseBasket extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_masterbasket', [
            'warehouse' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'after'          => 'id_basket'
            ]
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('tbl_masterbasket', 'warehouse');
    }
}
