<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DebtDetail extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Payment_model', 'Vendor_model'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/debtDetail';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = ['assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js'];
      $Datas['AddJsFooter'] = [];

      $Datas['DataVendor'] = $this->Payment_model->vendorSelected();

      $this->Layouts($Datas);
    }

    function Report(){
      $this->load->helper('exportexcel');

      $VendorId = $this->input->post('VendorId');
      $dataHutang = $this->Payment_model->detailHutang($VendorId);
      
      $namaFile = "Detail-Hutang.xls";
      $judul = "Detail-Hutang";
      $tablehead = 0;
      $tablebody = 1;
      $nourut = 1;
      //penulisan header
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Content-Disposition: attachment;filename=" . $namaFile . "");
      header("Content-Transfer-Encoding: binary ");

      xlsBOF();

      $kolomhead = 0;
      xlsWriteLabel($tablehead, $kolomhead++, "No");
      xlsWriteLabel($tablehead, $kolomhead++, "Nama Vendor");
      xlsWriteLabel($tablehead, $kolomhead++, "");
      xlsWriteLabel($tablehead, $kolomhead++, "Nomer Bukti");
      xlsWriteLabel($tablehead, $kolomhead++, "No. Invoice");
      xlsWriteLabel($tablehead, $kolomhead++, "Tgl. Invoice");
      xlsWriteLabel($tablehead, $kolomhead++, "No. Faktur Pajak");
      xlsWriteLabel($tablehead, $kolomhead++, "Tipe Pembayaran");
      xlsWriteLabel($tablehead, $kolomhead++, "Real Cost ");
      xlsWriteLabel($tablehead, $kolomhead++, "PPN");
      xlsWriteLabel($tablehead, $kolomhead++, "Jenis PPN");
      xlsWriteLabel($tablehead, $kolomhead++, "PPH");
      xlsWriteLabel($tablehead, $kolomhead++, "Total Value");
      xlsWriteLabel($tablehead, $kolomhead++, "Saldo Hutang");

      foreach ($dataHutang as $data) {
          $kolombody = 0;

          $PpnValue = round(($data->RealCost * $data->PpnValue)/100);
          $PphValue = round(($data->RealCost * $data->PphValue)/100);

          //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
          xlsWriteNumber($tablebody, $kolombody++, $nourut);
          xlsWriteLabel($tablebody, $kolombody++, $data->VendorName);
          xlsWriteLabel($tablebody, $kolombody++, $data->BillTypeCode);
          xlsWriteLabel($tablebody, $kolombody++, $data->BuktiNo);
          xlsWriteLabel($tablebody, $kolombody++, $data->InvoiceNo);
          xlsWriteLabel($tablebody, $kolombody++, $data->InvoiceDate);
          xlsWriteLabel($tablebody, $kolombody++, $data->FakturNo);
          xlsWriteLabel($tablebody, $kolombody++, $data->PaymentTypeCode);
          xlsWriteLabel($tablebody, $kolombody++, $data->RealCost);
          xlsWriteLabel($tablebody, $kolombody++, $PpnValue);
          xlsWriteLabel($tablebody, $kolombody++, $data->PpnName);
          xlsWriteLabel($tablebody, $kolombody++, $PphValue);
          xlsWriteLabel($tablebody, $kolombody++, $data->TotalValue);
          xlsWriteLabel($tablebody, $kolombody++, ($data->Debt ? $data->Debt : $data->TotalValue));

          $tablebody++;
          $nourut++;
      }

      xlsEOF();
      exit();
    }

    function DebtReport(){
      $this->load->helper('exportexcel');

      $VendorId = $this->input->post('VendorId', TRUE);
      $PenerimaanInvoiceId = $this->input->post('PenerimaanInvoiceId', TRUE);
      $PaymentStatus = $this->input->post('PaymentStatus', TRUE);

      $dataHutang = $this->Payment_model->debtList($VendorId, $PenerimaanInvoiceId, $PaymentStatus);
      
      $namaFile = "Detail_Hutang".date("Y-m-d").".xls";
      $judul = "Detail_Hutang".date("Y-m-d");
      $tablehead = 0;
      $tablebody = 1;
      $nourut = 1;
      //penulisan header
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Content-Disposition: attachment;filename=" . $namaFile . "");
      header("Content-Transfer-Encoding: binary ");

      xlsBOF();

      $kolomhead = 0;
      xlsWriteLabel($tablehead, $kolomhead++, "No");
      xlsWriteLabel($tablehead, $kolomhead++, "Nomer Bukti");
      xlsWriteLabel($tablehead, $kolomhead++, "Nama Vendor");
      xlsWriteLabel($tablehead, $kolomhead++, "No. Invoice");
      xlsWriteLabel($tablehead, $kolomhead++, "Tgl. Invoice");
      xlsWriteLabel($tablehead, $kolomhead++, "Total Tagihan");
      xlsWriteLabel($tablehead, $kolomhead++, "Total Pembayaran");
      xlsWriteLabel($tablehead, $kolomhead++, "Saldo Hutang");
      xlsWriteLabel($tablehead, $kolomhead++, "Status Hutang");

      foreach ($dataHutang as $data) {
          $kolombody = 0;

          //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
          xlsWriteNumber($tablebody, $kolombody++, $nourut);
          xlsWriteLabel($tablebody, $kolombody++, $data->BuktiNo);
          xlsWriteLabel($tablebody, $kolombody++, $data->VendorName);
          xlsWriteLabel($tablebody, $kolombody++, $data->InvoiceNo);
          xlsWriteLabel($tablebody, $kolombody++, $data->InvoiceDate);
          xlsWriteLabel($tablebody, $kolombody++, $data->TotalValue);
          xlsWriteLabel($tablebody, $kolombody++, $data->TotalPayment);
          xlsWriteLabel($tablebody, $kolombody++, $data->SaldoHutang);
          xlsWriteLabel($tablebody, $kolombody++, $data->PaymentStatus);

          $tablebody++;
          $nourut++;
      }

      xlsEOF();
      exit();
    }

    function debtList(){
      $VendorId = $this->input->post('VendorId', TRUE);
      $PenerimaanInvoiceId = $this->input->post('PenerimaanInvoiceId', TRUE);
      $PaymentStatus = $this->input->post('PaymentStatus', TRUE);

      $ListPayment = $this->Payment_model->debtList($VendorId, $PenerimaanInvoiceId, $PaymentStatus);
      echo json_encode($ListPayment);
    }

    function ReportByVendor($id){
      $this->load->library('m_pdf');
      if(!$id){
        show_404();
      }

      $DataInvoice = $this->Payment_model->getInvoice($id);
      $DataPembayaran = $this->Payment_model->getPembayaran($id);
      $Vendor = $this->Vendor_model->get_by_id_obj($id);


      ob_start();
        $this->load->view('report/debtDetailByVendor',array('DataInvoice' => $DataInvoice, 'DataPembayaran' => $DataPembayaran, 'Vendor' => $Vendor));
        $html = ob_get_contents();
      ob_end_clean();

      $pdf = new mPDF('utf-8', 'A4');
      $pdf->AddPage('L');
      $pdf->WriteHtml($html);
      $pdf->Output('test.pdf', 'I');
    }

    function ReportByInvoice($id){
      $this->load->library('m_pdf');
      if(!$id){
        show_404();
      }

      $DataInvoice = $this->Payment_model->getInvoice(NULL, $id);
      $DataPembayaran = $this->Payment_model->getPembayaran(NULL, $id);

      ob_start();
        $this->load->view('report/debtDetailByInvoice',array('DataInvoice' => $DataInvoice, 'DataPembayaran' => $DataPembayaran));
        $html = ob_get_contents();
      ob_end_clean();

      $pdf = new mPDF('utf-8', 'A4');
      $pdf->AddPage('L');
      $pdf->WriteHtml($html);
      $pdf->Output('test.pdf', 'I');
    }

}

/* End of file DebtDetail.php */
/* Location: ./application/controllers/DebtDetail.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-13 09:33:16 */
/* http://harviacode.com */
