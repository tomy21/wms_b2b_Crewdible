<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\ModelMasterBasket;
use App\Models\ModelOrder;
use App\Models\PackingModel;
use App\Models\PickingModel;
use TCPDF;

class Sorting extends BaseController
{
    public function index()
    {
        return view('sorting/index');
    }
    public function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $modelTemp = new InvoiceModel();
            $data = [
                'datatemp' => $modelTemp->getDataSorting()
            ];
            $json = [
                'data' => view('/sorting/dataTemp', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    function postDataSorting()
    {
        $id = $this->request->getVar('id');

        $modalInvoice = new InvoiceModel();
        $modalOrder = new ModelOrder();
        $modalPicking = new PickingModel();
        $modalBasket = new ModelMasterBasket();
        $cekData = $modalInvoice->getWhere(['id_basket' => $id, 'status' => 3])->getResult();
        $cekStatus = $modalPicking->getWhere(['id_basket' => $id, 'status' => 1])->getRow();

        if ($cekData == null) {
            $json = [
                'error' => 'Basket sudah kosong'
            ];
        } else {
            if (!is_null($cekStatus)) {
                foreach ($cekData as $x) {
                    $cekData = $modalInvoice->getWhere(['id_basket' => $id, 'status' => 1, 'Item_id' => $cekStatus->Item_id])->getRow();
                    $modalInvoice->update($x->id, ['status' => 4]);
                    $modalOrder->update($x->Order_id, ['status' => 4]);
                }
                $json = [
                    'success'   => 'Berhasil discan'
                ];
            } else {
                $json = [
                    'error' => 'Basket tidak ada isi'
                ];
            }

            $modalBasket->update($id, ['kap_order' => 0, 'status' => 0]);
            $json = [
                'success'   => 'Berhasil discan'
            ];
        }

        echo json_encode($json);
    }
    public function invoice($string, $tipe = "PNG")
    {
        set_time_limit(60);
        $id = $this->request->uri->getSegment(3);

        $modelInvoice = new ModelOrder();
        $modelInv       = new InvoiceModel();
        $modelPacking   = new PackingModel();
        $order = $modelInvoice->find($id);
        $cekData = $modelInv->getWhere(['Order_id' => $id]);
        $listItem = $modelInv->where('Order_id', $id)->select('id,Item_id,Item_detail,quantity')->get()->getResultArray();
        $data = [
            'order_id'  => $id,
            'list'      => json_encode($listItem)
        ];
        $modelPacking->insert($data);
        foreach ($cekData->getResult() as $row) {
            $modelInv->update($row->id, ['status' => 5]);
            $modelInvoice->update($row->id, ['status' => 5]);
        }

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Invoice BMI ');
        $pdf->SetTitle("Invoice $id ");
        $pdf->SetSubject("Invoice $id ");

        $pdf->AddPage();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 2, // width of a single module in points
            'module_height' => 2 // height of a single module in points
        );
        $style2 = array(
            'position' => 'L',
            'align' => 'L',
            'stretch' => false,
            'fitwidth' => false,
            'cellfitalign' => 'L',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false,
            'text' => true,
            'label' => $id,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        $modelInvoice = new ModelOrder();
        $order = $modelInvoice->find($id);
        // var_dump($order);
        // die;
        $html =  view('Layout/invoice', [
            'date'          => $order['created_at'],
            'noOrder'       => $id,
            'drop_date'     => $order['Drop_date'],
            'penerima'      => $order['Drop_name'],
            'address'       => $order['Drop_address'],
            'contact'       => $order['Drop_contact'],
            'data'          => $cekData,
            'barcode'       => $pdf->write2DBarcode($id, 'QRCODE,L', 100, 25, 30, 30, $style),
            'barcode1'       => $pdf->write1DBarcode($id, 'C128B', '', 10, '', 20, 0.4, $style2, 'N'),
        ]);
        $orderId = $order['Order_id'];
        $pdf->writeHTML($html, true, true, true, true, '');
        $this->response->setContentType('application/pdf');
        $pdf->Output('' . $orderId . '.pdf', 'I');
    }
}