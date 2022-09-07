<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMasterBasket;
use TCPDF;

class Basket extends BaseController
{
    public function index()
    {
        $modalBasket = new ModelMasterBasket();

        return view('basket/basketMaster', ['data' => $modalBasket->findAll()]);
    }
    public function printBasket($string, $tipe = "PNG")
    {
        set_time_limit(60);
        $id = $this->request->uri->getSegment(3);

        $modelInvoice = new ModelMasterBasket();
        $order = $modelInvoice->find($id);
        $cekData = $modelInvoice->getWhere(['id_basket' => $id]);

        $pdf = new TCPDF('P', PDF_UNIT, 'A8', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Barcode Basket ');
        $pdf->SetTitle("Basket $id ");
        $pdf->SetSubject("Basket $id ");

        $pdf->AddPage();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 200, // width of a single module in points
            'module_height' => 200 // height of a single module in points
        );

        $html =  view('basket/print', [

            'id_basket'   => $id,
            'barcode'   => $pdf->write2DBarcode($id, 'QRCODE,M', 10, 10, 30, 30, $style),
        ]);
        $pdf->writeHTML($html, true, true, true, true, '');
        $this->response->setContentType('application/pdf');
        $pdf->Output('example_001.pdf', 'I');
    }
    public function modalBasket()
    {
        if ($this->request->isAJAX()) {
            $modalStock = new ModelMasterBasket();
            $data = $modalStock->idBasket();
            $json = [
                'data' => view('basket/modalbasket', ['idBasket' => $data]),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function addBasket()
    {
        if ($this->request->isAJAX()) {
            $idbasket = $this->request->getPost('idbasket');
            $panjang = $this->request->getPost('panjang');
            $lebar = $this->request->getPost('lebar');
            $tinggi = $this->request->getPost('tinggi');

            $modelBasket = new ModelMasterBasket();
            $cekId = $modelBasket->getWhere(['id_basket' => $idbasket])->getResult();
            $findId = $modelBasket->find($idbasket);

            $volume = intval($panjang) * intval($lebar) * intval($tinggi);
            if ($volume <= 20000) {
                $type = "small";
            } elseif ($volume >= 20000) {
                $type = "medium";
            } elseif ($volume <= 80000) {
                $type = "large";
            } else {
                $type = "extra large";
            }

            if ($type = "small") {
                $kapasitas = 15;
            } elseif ($type = "medium") {
                $kapasitas = 25;
            } elseif ($type = "large") {
                $kapasitas = 35;
            } else {
                $kapasitas = 50;
            }

            if ($findId > 0) {
                $json = [
                    'error' => 'Id sudah ada...'
                ];
            } else {
                $modelBasket->insert([
                    'id_basket'     => $idbasket,
                    'type'          => $type,
                    'kapasitas'     => $kapasitas,
                ]);

                $json = [
                    'success'       => 'Basket berhasil ditambah'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}