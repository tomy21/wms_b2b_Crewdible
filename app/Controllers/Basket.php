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

        return view('basket/basketMaster');
    }
    public function printBasket($string, $tipe = "PNG")
    {
        set_time_limit(60);
        $id = $this->request->uri->getSegment(3);

        $modelInvoice = new ModelMasterBasket();
        $order = $modelInvoice->find($id);
        $cekData = $modelInvoice->getWhere(['id_basket' => $id]);

        $pdf = new TCPDF('L', PDF_UNIT, 'A6', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Barcode Basket ');
        $pdf->SetTitle("Basket $id ");
        $pdf->SetSubject("Basket $id ");

        $pdf->AddPage();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $style = array(
            'position' => 'C',
            'align' => 'C',
            'stretch' => true,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(127, 0, 0),
            'bgcolor' => array(255, 255, 240),
            'text' => true,
            'label' => $id,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        // $pdf->Cell(0, 0, 'CODE 39 EXTENDED + CHECKSUM', 0, 1);
        // $pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0)));
        $out = $pdf->write1DBarcode($id, 'C128B', '', 30, 150, 30, 0.9, $style, 'N');

        $html =  view('basket/print', [
            'barcode'   => $out
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
                'data' => view('basket/modalBasket', ['idBasket' => $data]),
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
            $warehouse = $this->request->getPost('warehouse');
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
                    'warehouse'     => $warehouse,
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
    function hapusBasket()
    {
        $id = $this->request->getPost('idBasket');
        $model = new ModelMasterBasket();
        $model->delete($id);
        $json = [
            'success' => 'Basket berhasil di haspus'
        ];
        echo json_encode($json);
    }
}