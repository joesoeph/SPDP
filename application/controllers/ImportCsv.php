<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImportCsv extends Parent_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Payment_model');
        $this->load->library('csvimport');
    }
 
    function index() {
      $this->Content = 'content/importCsv';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      $Datas['TempData'] = '';
      $this->Payment_model->truncateTempImportPayment();
      $this->DeleteCsv();
      $this->Layouts($Datas);
    }
 
    function importcsv() {
      $Datas['error'] = '';    //initialize image upload error array to empty
      $config['upload_path'] = './upload/csv/';
      $config['allowed_types'] = 'csv';
      $config['max_size'] = '1000';

      $this->load->library('upload', $config);

      // If upload failed, display error
      if (!$this->upload->do_upload()) {
          echo $this->upload->display_errors();
          $Datas['error'] = $this->upload->display_errors();
      } else {
          $file_data = $this->upload->data();
          $file_path =  './upload/csv/'.$file_data['file_name'];

          if ($this->csvimport->get_array($file_path)) {
              $csv_array = $this->csvimport->get_array($file_path);
              // var_dump($csv_array);
              foreach ($csv_array as $row) {
                  $NOMER_BUKTI  = str_pad(($row['NOMER_BUKTI']), 4, '0', STR_PAD_LEFT);
                  $JENIS_BERKAS = $row['JENIS_BERKAS'];
                  $TGL          = explode("/", $row['TANGGAL_BAYAR']);
                  $TANGGAL_BAYAR= $TGL[2]."-".$TGL[1]."-".$TGL[0];
                  $NILAI        = $row['NILAI'];
                  $DataInvoice = $this->Payment_model->getInvoiceByNoBukti($JENIS_BERKAS, $NOMER_BUKTI);
                  if($DataInvoice){
                    $insert_data  = array(
                        'PaymentId'           =>  uniqid().uniqid(),
                        'PenerimaanInvoiceId' =>  $DataInvoice->PenerimaanInvoiceId,
                        'VendorId'            =>  $DataInvoice->VendorId,
                        'PaymentDate'         =>  $TANGGAL_BAYAR,
                        'PaymentValue'        =>  $NILAI,
                    );
                    $this->Payment_model->insertTempImportPayment($insert_data);
                  }
              }
          } else {
               $this->session->set_flashdata('message', 'Error');
          }

          $this->Content = 'content/importCsv';
          $Datas['AddCss'] = [];
          $Datas['AddJsHeader'] = [];
          $Datas['AddJsFooter'] = [];

          $Datas['TempData'] = $this->Payment_model->getTempImportPayment();

          $this->Layouts($Datas);
        }
    }

    function Validate(){
      if($this->Payment_model->validateTempPayment()){
        $this->session->set_flashdata('message', 'Import sukses');
        $this->Payment_model->truncateTempImportPayment();
      }else{
        $this->session->set_flashdata('message', 'Import gagal');
      }
      $this->DeleteCsv();
      redirect(site_url('ImportCsv'));
    }

    function Cancel(){
      $this->Payment_model->truncateTempImportPayment();
      $this->session->set_flashdata('message', 'Import dibatalkan');
      redirect(site_url('ImportCsv'));
    }

    function DeleteCsv(){
      $files = glob('./upload/csv/*'); // get all file names
      foreach($files as $file){ // iterate files
        if(is_file($file))
          unlink($file); // delete file
      }
    }

}
