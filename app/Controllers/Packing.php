<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelItemTemp;
use App\Models\ModelOrder;
use App\Models\ModelOrderDone;
use App\Models\PackingModel;
use App\Models\PickingModel;
use App\Models\StockModel;
use BaconQrCode\Renderer\Path\Path;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use TCPDF;
use Picqer;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Packing extends BaseController
{
    public function __construct()
    {
        // $this->ModelDone = new ModelOrderDone();
        $this->ModelOrder = new ModelOrder();
        $this->ModePacking = new PackingModel();
        $this->ModelInv = new InvoiceModel();
    }
    public function index()
    {

        $modelTemp = new PackingModel();

        $data = [
            'datatemp' => $modelTemp->findAll(),
        ];

        return view('warehouse/data', $data);
    }
}