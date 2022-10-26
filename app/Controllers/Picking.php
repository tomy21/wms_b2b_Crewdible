<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\TblMasteritem;
use App\Models\InvoiceModel;
use App\Models\ModelAssign;
use App\Models\ModelItemTemp;
use App\Models\ModelMasterBasket;
use App\Models\ModelMasterItem;
use App\Models\ModelOrder;
use App\Models\PickingModel;
use App\Models\StockModel;

class Picking extends BaseController
{
    public function __construct()
    {
        $this->ModelInv = new InvoiceModel();
        $this->modelOrder = new ModelOrder();
        $this->modelPicking = new PickingModel();
    }
    public function index()
    {
        $warehouse = user()->warehouse;

        // $data = [
        //     'data'      => $this->modelPicking->tampilDataTransaksi($warehouse)

        // ];
        return view('picking/picking');
    }
}