<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Payment_model');
        $this->load->library('form_validation');
    }

    public function read($id)
    {
      $this->Content = 'content/paymentForm';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = ['assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js'];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js'
      ];

      $row = $this->Payment_model->get_by_id($id);
      if ($row) {
          $Datas['ArrData'] = array(
            'button' => '',
            'action' => site_url('Payment/create_action'),
          	'PaymentId' => $row->PaymentId,
          	'PenerimaanInvoiceId' => $row->PenerimaanInvoiceId,
          	'VendorId' => $row->VendorId,
            'PaymentDate' => $row->PaymentDate,
          	'PaymentValue' => $row->PaymentValue,
          	'CreatedDate' => $row->CreatedDate,
          	'CreatedByUserId' => $row->CreatedByUserId,
          	'LastChangedDate' => $row->LastChangedDate,
          	'LastChangedByUserId' => $row->LastChangedByUserId,
          	'DeletedDate' => $row->DeletedDate,
          	'DeletedUserId' => $row->DeletedUserId,
          );

          $Datas['DataVendor'] = $this->Payment_model->vendorSelected($row->PaymentId);
          $Datas['DataInvoice'] = $this->Payment_model->invoiceSelected($row->PaymentId);
          $this->Layouts($Datas);
      } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Payment'));
      }
    }

    public function index()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');

      $this->Content = 'content/paymentForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css',
        'assets/vendor/bootstrap-fileinput-master/css/fileinput.css',
      ];
      $Datas['AddJsHeader'] = ['assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js'];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js',
        'assets/vendor/bootstrap-fileinput-master/js/fileinput.js',
      ];

      if(!$arrAccessMenu[10]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('Payment/create_action'),
            'PaymentId' => set_value('PaymentId'),
            'PenerimaanInvoiceId' => set_value('PenerimaanInvoiceId'),
            'VendorId' => set_value('VendorId'),
            'PaymentValue' => set_value('PaymentValue'),
            'PaymentDate' => set_value('PaymentDate', date('Y-m-d')),
            'CreatedDate' => set_value('CreatedDate'),
            'CreatedByUserId' => set_value('CreatedByUserId'),
            'LastChangedDate' => set_value('LastChangedDate'),
            'LastChangedByUserId' => set_value('LastChangedByUserId'),
            'DeletedDate' => set_value('DeletedDate'),
            'DeletedUserId' => set_value('DeletedUserId'),
        );

        $Datas['DataVendor'] = $this->Payment_model->vendorSelected();
        $Datas['DataInvoice'] = $this->Payment_model->invoiceSelected();
      }

      $this->Layouts($Datas);
    }

    public function create_action()
    {
      $this->_rules();

        $PaymentId = $this->input->post('PaymentId',TRUE);
        
        if($PaymentId){
          $PaymentValue = explode(".",($this->input->post('PaymentValue',TRUE)));
          $PaymentValue = str_replace(",","",($PaymentValue[0]));

          $PenerimaanInvoice = $this->Payment_model->get_by_id($PaymentId);

          $data = array(
            'PenerimaanInvoiceId' => $PenerimaanInvoice->PenerimaanInvoiceId,
            'VendorId' => $PenerimaanInvoice->VendorId,
            'PaymentDate' => $this->input->post('PaymentDate',TRUE),
            'PaymentValue' => $PaymentValue,
            'LastChangedDate' => date("Y-m-d H:i:s"),
            'LastChangedByUserId' => $this->session->userdata('user_id')
          );

          $this->Payment_model->update($PaymentId, $data);
          echo 'Success';
        }else{
          if ($this->form_validation->run() == FALSE) {
              echo 'Fail';
          }else{
            $PaymentId = uniqid();
            $PaymentId.= uniqid();
            $PaymentValue = explode(".",($this->input->post('PaymentValue',TRUE)));
            $PaymentValue = str_replace(",","",($PaymentValue[0]));
            $data = array(
              'PaymentId' => $PaymentId,
              'PenerimaanInvoiceId' => $this->input->post('PenerimaanInvoiceId',TRUE),
              'VendorId' => $this->input->post('VendorId',TRUE),
              'PaymentDate' => $this->input->post('PaymentDate',TRUE),
              'PaymentValue' => $PaymentValue,
              'CreatedDate' => date("Y-m-d H:i:s"),
              'CreatedByUserId' => $this->session->userdata('user_id')
            );

            $this->Payment_model->insert($data);
            echo 'Success';
          }
        }
    }

    public function update($id)
    {
      $this->Content = 'content/paymentForm';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = ['assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js'];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js'
      ];

      $row = $this->Payment_model->get_by_id($id);

      if ($row) {
        $Datas['ArrData'] = array(
          'button' => 'Perbarui',
          'action' => site_url('Payment/update_action/'.$id),
          'PaymentId' => set_value('PaymentId', $row->PaymentId),
          'PenerimaanInvoiceId' => set_value('PenerimaanInvoiceId', $row->PenerimaanInvoiceId),
          'VendorId' => set_value('VendorId', $row->VendorId),
          'PaymentDate' => set_value('PaymentDate', $row->PaymentDate),
          'PaymentValue' => set_value('PaymentValue', $row->PaymentValue),
          'CreatedDate' => set_value('CreatedDate', $row->CreatedDate),
          'CreatedByUserId' => set_value('CreatedByUserId', $row->CreatedByUserId),
          'LastChangedDate' => set_value('LastChangedDate', $row->LastChangedDate),
          'LastChangedByUserId' => set_value('LastChangedByUserId', $row->LastChangedByUserId),
          'DeletedDate' => set_value('DeletedDate', $row->DeletedDate),
          'DeletedUserId' => set_value('DeletedUserId', $row->DeletedUserId),
        );

        $Datas['DataVendor'] = $this->Payment_model->vendorSelected($row->PaymentId);
        $Datas['DataInvoice'] = $this->Payment_model->invoiceSelected($row->PaymentId);

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Payment'));
      }

    }

    public function update_action($id)
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $PaymentValue = explode(".",($this->input->post('PaymentValue',TRUE)));
            $PaymentValue = str_replace(",","",($PaymentValue[0]));
            $data = array(
          		'PenerimaanInvoiceId' => $this->input->post('PenerimaanInvoiceId',TRUE),
          		'VendorId' => $this->input->post('VendorId',TRUE),
              'PaymentDate' => $this->input->post('PaymentDate',TRUE),
          		'PaymentValue' => $PaymentValue,
          		'LastChangedDate' => date("Y-m-d H:i:s"),
              'LastChangedByUserId' => $this->session->userdata('user_id')
          	);

            $this->Payment_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('Payment'));
        }
    }

    public function delete($id)
    {
      $row = $this->Payment_model->get_by_id($id);

      if ($row) {
        $data = array(
                  'DeletedDate' => date('Y-m-d H:i:s'),
                  'DeletedUserId' => $this->session->userdata('user_id')
                );

        $this->Payment_model->update($row->PaymentId, $data);
        echo 'Success';
      } else {
        echo 'Fail';
      }
    }

    public function _rules()
    {
    	$this->form_validation->set_rules('PenerimaanInvoiceId', 'penerimaaninvoiceid', 'trim|required');
    	$this->form_validation->set_rules('VendorId', 'vendorid', 'trim|required');
      $this->form_validation->set_rules('PaymentDate', 'paymentdate', 'trim|required');
    	$this->form_validation->set_rules('PaymentValue', 'paymentvalue', 'trim|required');

    	$this->form_validation->set_rules('PaymentId', 'PaymentId', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    function Report(){
      $this->load->helper('exportexcel');

      $VendorId             = $this->input->post('VendorId');
      $PenerimaanInvoiceId  = $this->input->post('PenerimaanInvoiceId');
      $From                 = $this->input->post('From');
      $To                   = $this->input->post('To');
      $dataHutang           = $this->Payment_model->detailHutang($VendorId, $PenerimaanInvoiceId, $From, $To);
      
      $namaFile = "Info_Pembayaran_".date("Y-m-d").".xls";
      $judul = "Info_Pembayaran";
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
      xlsWriteLabel($tablehead, $kolomhead++, "Tgl. Terima");
      xlsWriteLabel($tablehead, $kolomhead++, "No. Faktur Pajak");
      xlsWriteLabel($tablehead, $kolomhead++, "Tipe Pembayaran");
      xlsWriteLabel($tablehead, $kolomhead++, "Real Cost ");
      xlsWriteLabel($tablehead, $kolomhead++, "PPN");
      xlsWriteLabel($tablehead, $kolomhead++, "Jenis PPN");
      xlsWriteLabel($tablehead, $kolomhead++, "PPH");
      xlsWriteLabel($tablehead, $kolomhead++, "Total Value");
      xlsWriteLabel($tablehead, $kolomhead++, "Total Bayar");
      xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Bayar");
      //xlsWriteLabel($tablehead, $kolomhead++, "Saldo Hutang");

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
          xlsWriteLabel($tablebody, $kolombody++, $data->ReceivedDate);
          xlsWriteLabel($tablebody, $kolombody++, $data->FakturNo);
          xlsWriteLabel($tablebody, $kolombody++, $data->PaymentTypeCode);
          xlsWriteLabel($tablebody, $kolombody++, $data->RealCost);
          xlsWriteLabel($tablebody, $kolombody++, $PpnValue);
          xlsWriteLabel($tablebody, $kolombody++, $data->PpnName);
          xlsWriteLabel($tablebody, $kolombody++, $PphValue);
          xlsWriteLabel($tablebody, $kolombody++, $data->TotalValue);
          xlsWriteLabel($tablebody, $kolombody++, $data->PaymentValue);
          xlsWriteLabel($tablebody, $kolombody++, $data->PaymentDate);
          //xlsWriteLabel($tablebody, $kolombody++, ($data->Debt ? $data->Debt : $data->TotalValue));

          $tablebody++;
          $nourut++;
      }

      xlsEOF();
      exit();
    }

    public function getPaymentById($PaymentId = NULL){
      $DataPeyment = $this->Payment_model->get_by_id($PaymentId);
      echo json_encode($DataPeyment);
    }

    public function invoiceSelected(){
      $VendorId = $this->input->post('VendorId', TRUE);
      $DataInvoiceSelected = $this->Payment_model->invoicePaymentSelected($VendorId);
      echo json_encode(
            array( 
              'DataInvoiceSelected' => $DataInvoiceSelected
              )
            );
    }

    public function getDetailPayment(){
      $VendorId             = $this->input->post('VendorId', TRUE);
      $PaymentId            = $this->input->post('PaymentId', TRUE);
      $From                 = $this->input->post('From', TRUE);
      $To                   = $this->input->post('To', TRUE);
      $PenerimaanInvoiceId  = $this->input->post('PenerimaanInvoiceId', TRUE);
      
      $DataInvoice = $this->Payment_model->getInvoice($VendorId, $PenerimaanInvoiceId);
      $DataPembayaran = $this->Payment_model->getPembayaran($VendorId, $PenerimaanInvoiceId, $From, $To);
      $DataInvoiceSelected = $this->Payment_model->invoicePaymentSelected($VendorId);
      echo json_encode(
            array(
              'DataInvoice' => $DataInvoice, 
              'DataPembayaran' => $DataPembayaran, 
              'DataInvoiceSelected' => $DataInvoiceSelected
              )
            );
    }
}

/* End of file Payment.php */
/* Location: ./application/controllers/Payment.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-28 16:53:39 */
/* http://harviacode.com */