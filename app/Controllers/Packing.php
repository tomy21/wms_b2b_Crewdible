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
use Config\Services;

class Packing extends BaseController
{
    public function __construct()
    {
        $request = Services::request();
        $this->ModelOrder = new ModelOrder($request);
        $this->ModePacking = new PackingModel($request);
        $this->ModelInv = new InvoiceModel();
    }
    public function index()
    {
        return view('warehouse/data');
    }
    function dataAjax()
    {
        $request = Services::request();
        $dataQuery = new PackingModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $dataQuery->getDatatables();
            $data = [];
            $no = $request->getPost('start');
            foreach ($lists as $list) {
                $no++;
                $row = [];

                if ($list->Status == 0) {
                    $status = "<span class=\"badge badge-dark\">Proses</span>";
                }else if($list->Status == 1){
                    $status = "<span class=\"badge badge-warning\">Done</span>";
                } else if ($list->Status == 2) {
                    $status = "<span class=\"badge badge-warning\">Done</span>";
                }else {
                    $status = "<span class=\"badge badge-success\">Done Manifest</span>";
                }

                $modelOrder = new ModelOrder($request);
                $dataUser = $modelOrder->getWhere(['Order_id'=> $list->order_id])->getResult();
                $nama = null;
                $alamat = null;
                foreach($dataUser as $z){
                    $nama = $z->Drop_name;
                    $alamat = $z->Drop_address;
                }

                

                $foto = "<img src=\"https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com/aws-b2b/". $list->foto."\" width=\"50\">";
                $fotoAfter = "<img src=\"https://crewdible-sandbox-asset.s3.ap-southeast-1.amazonaws.com/aws-b2b/".$list->foto_after."\"  width=\"50\">";

                $row[] = $no;
                $row[] = $list->order_id;
                $row[] = $list->warehouse;
                $row[] = $nama;
                $row[] = $alamat;
                $row[] = $foto;
                $row[] = $fotoAfter;
                $row[] = $list->assign;
                $row[] = $status;
                $row[] = $list->updated_at;
                $data[] = $row;
            }
            $output = array(
                'draw'              => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
                'recordsTotal' => $dataQuery->countAll(),
                'recordsFiltered' => $dataQuery->countFiltered(),
                'data'              => $data,
            );

            echo json_encode($output);
        }
    }
}