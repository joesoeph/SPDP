<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agreement extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Agreement_model', 'GlobalModel', 'ListDataModel'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/agreementList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[3]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }
      
      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/agreementForm';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/vendor/tinymce/tinymce.min.js'
      ];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js'
      ];

      $row = $this->Agreement_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[3]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
             $Datas['ArrData'] = array(
                'button' => '',
                'action' => site_url('Agreement/create_action'),
                'AgreementId' => $row->AgreementId,
                'AgreementTypeId' => $row->AgreementTypeId,
                'ContractNo' => $row->ContractNo,
                'VendorId' => $row->VendorId,
                'Date' => $row->Date,
                'ContractAmount' => $row->ContractAmount,
                'WithPpn' => $row->WithPpn,
                'ContractAmountDescription' => $row->ContractAmountDescription,
                'ContractPeriodFrom' => $row->ContractPeriodFrom,
                'ContractPeriodTo' => $row->ContractPeriodTo,
                'ScopeOfWork' => $row->ScopeOfWork,
                'BasicOfWorkExecution' => $row->BasicOfWorkExecution,
                'PaymentTypeId' => $row->PaymentTypeId,
                'PaymentMethod' => $row->PaymentMethod,
                'ImplementPeriode' => $row->ImplementPeriode,
                'ImplementInsurrance' => $row->ImplementInsurrance,
                'Miscellanous' => $row->Miscellanous,
                'ReceivedAgreement' => $row->ReceivedAgreement,
                'ReceivedAgreementTitle' => $row->ReceivedAgreementTitle,
                'Sender1Name' => $row->Sender1Name,
                'Sender1Title' => $row->Sender1Title,
                'Sender2Name' => $row->Sender2Name,
                'Sender2Title' => $row->Sender2Title,
                'CreatedDate' => $row->CreatedDate,
                'CreatedByUserId' => $row->CreatedByUserId,
                'LastChangedDate' => $row->LastChangedDate,
                'LastChangedByUserId' => $row->LastChangedByUserId,
                'DeletedDate' => $row->DeletedDate,
                'DeletedUserId' => $row->DeletedUserId,
                'PrintStatus' => $row->PrintStatus
              );

            $Datas['DataAgreementType'] = $this->Agreement_model->viewAgreemntType($id);
            $Datas['DataPaymentType'] = $this->Agreement_model->viewPaymentType($id);
            $Datas['DataVendor'] = $this->Agreement_model->vendorSelected($id);
            $Datas['DataValueDescription'] = $this->Agreement_model->getValueDescriptionById($id);
        }

        $this->Layouts($Datas);
      } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Agreement'));
      }
    }

    public function create()
    {
      $this->Content = 'content/agreementForm';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/vendor/tinymce/tinymce.min.js'
      ];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js',
      ];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[3]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {

        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('Agreement/create_action'),
      	    'AgreementId' => set_value('AgreementId'),
      	    'AgreementTypeId' => set_value('AgreementTypeId'),
      	    'ContractNo' => set_value('ContractNo'),
      	    'VendorId' => set_value('VendorId'),
      	    'Date' => set_value('Date'),
            'ContractAmount' => set_value('ContractAmount'),
      	    'WithPpn' => set_value('WithPpn'),
      	    'ContractAmountDescription' => set_value('ContractAmountDescription'),
      	    'ContractPeriodFrom' => set_value('ContractPeriodFrom'),
            'ContractPeriodTo' => set_value('ContractPeriodTo'),
      	    'ScopeOfWork' => set_value('ScopeOfWork'),
      	    'BasicOfWorkExecution' => set_value('BasicOfWorkExecution'),
            'PaymentTypeId' => set_value('PaymentTypeId'),
            'PaymentMethod' => set_value('PaymentMethod'),
      	    'ImplementPeriode' => set_value('ImplementPeriode'),
      	    'ImplementInsurrance' => set_value('ImplementInsurrance'),
      	    'Miscellanous' => set_value('Miscellanous'),
      	    'ReceivedAgreement' => set_value('ReceivedAgreement'),
      	    'ReceivedAgreementTitle' => set_value('ReceivedAgreementTitle'),
      	    'Sender1Name' => set_value('Sender1Name'),
      	    'Sender1Title' => set_value('Sender1Title'),
      	    'Sender2Name' => set_value('Sender2Name'),
      	    'Sender2Title' => set_value('Sender2Title'),
            'CreatedByUserId' => '',
            'CreatedDate' => '',
            'LastChangedDate' => '',
            'LastChangedByUserId' => '',
            'DeletedUserId' => '',
            'DeletedDate' => '',
            'PrintStatus' => set_value('PrintStatus')
      	);

        $Datas['DataAgreementType'] = $this->Agreement_model->viewAgreemntType();
        $Datas['DataPaymentType'] = $this->Agreement_model->viewPaymentType();
        $Datas['DataVendor'] = $this->Agreement_model->vendorSelected();
        $Datas['DataValueDescription'] = '';
      }

      $this->Layouts($Datas);
    }

    public function create_action()
    {
      $this->_rules();

      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[3]['Write']){

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
          $ContractAmount = explode(".",($this->input->post('ContractAmount',TRUE)));
          $ContractAmount = str_replace(",","",($ContractAmount[0]));
          $AgreementId = uniqid();
          $AgreementId.= uniqid();
          $data = array(
            'AgreementId' => $AgreementId,
        		'AgreementTypeId' => $this->input->post('AgreementTypeId',TRUE),
        		'ContractNo' => $this->input->post('ContractNo',TRUE),
        		'VendorId' => $this->input->post('VendorId',TRUE),
        		'Date' => $this->input->post('Date',TRUE),
            'ContractAmount' => $ContractAmount, //$this->input->post('ContractAmount',TRUE),
        		'WithPpn' => ($this->input->post('WithPpn',TRUE) == 'on' ? 1 : 0),
        		'ContractAmountDescription' => $AgreementId,
        		'ContractPeriodFrom' => $this->input->post('ContractPeriodFrom',TRUE),
            'ContractPeriodTo' => $this->input->post('ContractPeriodTo',TRUE),
        		'ScopeOfWork' => $this->input->post('ScopeOfWork',TRUE),
        		'BasicOfWorkExecution' => $this->input->post('BasicOfWorkExecution',TRUE),
            'PaymentTypeId' => $this->input->post('PaymentTypeId',TRUE),
            'PaymentMethod' => $this->input->post('PaymentMethod',TRUE),
        		'ImplementPeriode' => $this->input->post('ImplementPeriode',TRUE),
        		'ImplementInsurrance' => $this->input->post('ImplementInsurrance',TRUE),
        		'Miscellanous' => $this->input->post('Miscellanous',TRUE),
        		'ReceivedAgreement' => $this->input->post('ReceivedAgreement',TRUE),
        		'ReceivedAgreementTitle' => $this->input->post('ReceivedAgreementTitle',TRUE),
        		'Sender1Name' => $this->input->post('Sender1Name',TRUE),
        		'Sender1Title' => $this->input->post('Sender1Title',TRUE),
        		'Sender2Name' => $this->input->post('Sender2Name',TRUE),
        		'Sender2Title' => $this->input->post('Sender2Title',TRUE),
            'CreatedDate' => date("Y-m-d H:i:s"),
            'CreatedByUserId' => $this->session->userdata('user_id'),
            'PrintStatus' => $this->input->post('PrintStatus',TRUE),
        	 );
          $exst = $this->GlobalModel->getDataByWhere('trnagreement', array('ContractNo' => $this->input->post('ContractNo',TRUE)));
          if($exst){
            $this->session->set_flashdata('message', 'No kontrak sudah digunakan');
            redirect(site_url('Agreement/update/'.$exst->AgreementId));
          }else{
            $this->Agreement_model->insert($data);

            //Save amount Description
            for ($i=1; $i <= $_POST['row']; $i++) {
              if($_POST['Quantity'][$i] || $_POST['UnitPrice'][$i] || $_POST['Description'][$i] || $_POST['Spesification'][$i] || $_POST['UnitPrice'][$i] || $_POST['Amount'][$i]){
                
                $UnitPrice = explode(".",($_POST['UnitPrice'][$i]));
                $UnitPrice = str_replace(",","",($UnitPrice[0]));
                
                $UnitAmount = explode(".",($_POST['Amount'][$i]));
                $UnitAmount = str_replace(",","",($UnitAmount[0]));
                
                $d = array(
                  'AgreementId' => $AgreementId,
                  'SortNo' => $i+1,
                  'Qty' => $_POST['Quantity'][$i],
                  'Unit' => $_POST['Unit'][$i],
                  'Description' => $_POST['Description'][$i],
                  'Spesification' => $_POST['Spesification'][$i],
                  //'UnitPrice' => $_POST['UnitPrice'][$i],
                  //'Amount' => $_POST['Amount'][$i],
                  'UnitPrice' => $UnitPrice,
                  'Amount' => $UnitAmount,
                );
                $this->Agreement_model->insertSeqValueDescription($d);
              }
            }

            //Save amount Description
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('Agreement/update/'.$AgreementId));
          }
        }
      } else {
          $this->session->set_flashdata('message', 'Anda tidak punya akses');
          redirect(site_url('Agreement'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/agreementForm';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/vendor/tinymce/tinymce.min.js'
      ];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js'
      ];

        $row = $this->Agreement_model->get_by_id($id);

        if ($row) {
          $arrAccessMenu = $this->session->userdata('access_menu');
          if(!$arrAccessMenu[3]['Update']){
            $this->Content = 'errors/dontHaveAccess';
          } else {
              $Datas['ArrData'] = array(
                  'button' => 'Perbarui',
                  'action' => site_url('Agreement/update_action/'.$id),
              		'AgreementId' => set_value('AgreementId', $row->AgreementId),
              		'AgreementTypeId' => set_value('AgreementTypeId', $row->AgreementTypeId),
              		'ContractNo' => set_value('ContractNo', $row->ContractNo),
              		'VendorId' => set_value('VendorId', $row->VendorId),
              		'Date' => set_value('Date', $row->Date),
                  'ContractAmount' => set_value('ContractAmount', $row->ContractAmount),
              		'WithPpn' => set_value('WithPpn', $row->WithPpn),
              		'ContractPeriodFrom' => set_value('ContractPeriodFrom', $row->ContractPeriodFrom),
                  'ContractPeriodTo' => set_value('ContractPeriodTo', $row->ContractPeriodTo),
              		'ScopeOfWork' => set_value('ScopeOfWork', $row->ScopeOfWork),
              		'BasicOfWorkExecution' => set_value('BasicOfWorkExecution', $row->BasicOfWorkExecution),
                  'PaymentTypeId' => set_value('PaymentTypeId', $row->PaymentTypeId),
                  'PaymentMethod' => set_value('PaymentMethod', $row->PaymentMethod),
              		'ImplementPeriode' => set_value('ImplementPeriode', $row->ImplementPeriode),
              		'ImplementInsurrance' => set_value('ImplementInsurrance', $row->ImplementInsurrance),
              		'Miscellanous' => set_value('Miscellanous', $row->Miscellanous),
              		'ReceivedAgreement' => set_value('ReceivedAgreement', $row->ReceivedAgreement),
              		'ReceivedAgreementTitle' => set_value('ReceivedAgreementTitle', $row->ReceivedAgreementTitle),
              		'Sender1Name' => set_value('Sender1Name', $row->Sender1Name),
              		'Sender1Title' => set_value('Sender1Title', $row->Sender1Title),
              		'Sender2Name' => set_value('Sender2Name', $row->Sender2Name),
              		'Sender2Title' => set_value('Sender2Title', $row->Sender2Title),
                  'CreatedByUserId' => $row->CreatedByUserId,
                  'CreatedDate' => $row->CreatedDate,
                  'LastChangedDate' => $row->LastChangedDate,
                  'LastChangedByUserId' => $row->LastChangedByUserId,
                  'DeletedUserId' => $row->DeletedUserId,
                  'DeletedDate' => $row->DeletedDate,
                  'PrintStatus' => set_value('PrintStatus', $row->PrintStatus),
              );

              $Datas['DataAgreementType'] = $this->Agreement_model->viewAgreemntType($id);
              $Datas['DataVendor'] = $this->Agreement_model->vendorSelected($id);
              $Datas['DataPaymentType'] = $this->Agreement_model->viewPaymentType($id);
              $Datas['DataValueDescription'] = $this->Agreement_model->getValueDescriptionById($id);
          }

          $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Agreement'));
      }
    }

    public function update_action($id)
    {
      $this->_rules();
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[3]['Write']){
        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $ContractAmount = explode(".",($this->input->post('ContractAmount',TRUE)));
            $ContractAmount = str_replace(",","",($ContractAmount[0]));

            $data = array(
          		'AgreementTypeId' => $this->input->post('AgreementTypeId', TRUE),
          		'ContractNo' => $this->input->post('ContractNo',TRUE),
          		'VendorId' => $this->input->post('VendorId',TRUE),
          		'Date' => $this->input->post('Date',TRUE),
              'ContractAmount' => $ContractAmount,
          		'WithPpn' => ($this->input->post('WithPpn',TRUE) == 'on' ? 1 : 0),
          		'ContractAmountDescription' => $id,
          		'ContractPeriodFrom' => $this->input->post('ContractPeriodFrom',TRUE),
              'ContractPeriodTo' => $this->input->post('ContractPeriodTo',TRUE),
          		'ScopeOfWork' => $this->input->post('ScopeOfWork',TRUE),
          		'BasicOfWorkExecution' => $this->input->post('BasicOfWorkExecution',TRUE),
              'PaymentTypeId' => $this->input->post('PaymentTypeId',TRUE),
          		'PaymentMethod' => $this->input->post('PaymentMethod',TRUE),
          		'ImplementPeriode' => $this->input->post('ImplementPeriode',TRUE),
          		'ImplementInsurrance' => $this->input->post('ImplementInsurrance',TRUE),
          		'Miscellanous' => $this->input->post('Miscellanous',TRUE),
          		'ReceivedAgreement' => $this->input->post('ReceivedAgreement',TRUE),
          		'ReceivedAgreementTitle' => $this->input->post('ReceivedAgreementTitle',TRUE),
          		'Sender1Name' => $this->input->post('Sender1Name',TRUE),
          		'Sender1Title' => $this->input->post('Sender1Title',TRUE),
          		'Sender2Name' => $this->input->post('Sender2Name',TRUE),
          		'Sender2Title' => $this->input->post('Sender2Title',TRUE),
              'LastChangedDate' => date("Y-m-d H:i:s"),
              'LastChangedByUserId' => $this->session->userdata('user_id'),
              'PrintStatus' => $this->input->post('PrintStatus',TRUE),
	          );

            $this->Agreement_model->update($id, $data);
            $this->Agreement_model->deleteSeqValueDescription($id);
            //Save amount Description
            for ($i=1; $i <= $_POST['row']; $i++) {
              if(
                  $_POST['Quantity'][$i] || $_POST['UnitPrice'][$i] || $_POST['Description'][$i] ||
                  $_POST['Spesification'][$i] || $_POST['UnitPrice'][$i] || $_POST['Amount'][$i]
                ){
                
                $UnitPrice = explode(".",($_POST['UnitPrice'][$i]));
                $UnitPrice = str_replace(",","",($UnitPrice[0]));
                
                $UnitAmount = explode(".",($_POST['Amount'][$i]));
                $UnitAmount = str_replace(",","",($UnitAmount[0]));
                
                $d = array(
                  'AgreementId' => $id,
                  'SortNo' => $i+1,
                  'Qty' => $_POST['Quantity'][$i],
                  'Unit' => $_POST['Unit'][$i],
                  'Description' => $_POST['Description'][$i],
                  'Spesification' => $_POST['Spesification'][$i],
                  //'UnitPrice' => $_POST['UnitPrice'][$i],
                  //'Amount' => $_POST['Amount'][$i],
                  'UnitPrice' => $UnitPrice,
                  'Amount' => $UnitAmount,
                );
                $this->Agreement_model->insertSeqValueDescription($d);
              }
            }
            // Save value Description

            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('Agreement/update/'.$id));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Agreement'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[3]['Delete']){
        $row = $this->Agreement_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date('Y-m-d H:i:s'),
                    'DeletedUserId' => $this->session->userdata('user_id')
                  );

          $this->Agreement_model->update($row->AgreementId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Agreement'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Agreement'));
        }
      } else {
          $this->session->set_flashdata('message', 'Anda tidak punya akses');
          redirect(site_url('Agreement'));
      }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('ContractNo', 'contract number', 'trim|required');
      	$this->form_validation->set_rules('VendorId', 'vendor name', 'trim|required');
      	$this->form_validation->set_rules('Date', 'Date', 'trim|required');
      	$this->form_validation->set_rules('ContractAmount', 'contract amount', 'trim|required');
      	$this->form_validation->set_rules('ContractPeriodFrom', 'date', 'trim|required');
      	$this->form_validation->set_rules('PaymentMethod', 'payment method', 'trim|required');

      	$this->form_validation->set_rules('AgreementId', 'AgreementId', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "trnagreement.xls";
        $judul = "trnagreement";
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
      	xlsWriteLabel($tablehead, $kolomhead++, "AgreementTypeId");
      	xlsWriteLabel($tablehead, $kolomhead++, "ContractNo");
      	xlsWriteLabel($tablehead, $kolomhead++, "VendorId");
      	xlsWriteLabel($tablehead, $kolomhead++, "Date");
      	xlsWriteLabel($tablehead, $kolomhead++, "ContractAmount");
      	xlsWriteLabel($tablehead, $kolomhead++, "ContractAmountDescription");
      	xlsWriteLabel($tablehead, $kolomhead++, "ContractPeriodFrom");
      	xlsWriteLabel($tablehead, $kolomhead++, "ScopeOfWork");
      	xlsWriteLabel($tablehead, $kolomhead++, "BasicOfWorkExecution");
      	xlsWriteLabel($tablehead, $kolomhead++, "PaymentMethod");
      	xlsWriteLabel($tablehead, $kolomhead++, "ImplementPeriode");
      	xlsWriteLabel($tablehead, $kolomhead++, "ImplementInsurrance");
      	xlsWriteLabel($tablehead, $kolomhead++, "Miscellanous");
      	xlsWriteLabel($tablehead, $kolomhead++, "ReceivedAgreement");
      	xlsWriteLabel($tablehead, $kolomhead++, "ReceivedAgreementTitle");
      	xlsWriteLabel($tablehead, $kolomhead++, "Sender1Name");
      	xlsWriteLabel($tablehead, $kolomhead++, "Sender1Title");
      	xlsWriteLabel($tablehead, $kolomhead++, "Sender2Name");
      	xlsWriteLabel($tablehead, $kolomhead++, "Sender2Title");
      	xlsWriteLabel($tablehead, $kolomhead++, "CreatedDate");
      	xlsWriteLabel($tablehead, $kolomhead++, "CreatedByUserId");
      	xlsWriteLabel($tablehead, $kolomhead++, "LastChangedDate");
      	xlsWriteLabel($tablehead, $kolomhead++, "LastChangedByUserId");
      	xlsWriteLabel($tablehead, $kolomhead++, "DeletedDate");
	      xlsWriteLabel($tablehead, $kolomhead++, "DeletedUserId");

	      foreach ($this->Agreement_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
      	    xlsWriteNumber($tablebody, $kolombody++, $data->AgreementTypeId);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ContractNo);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->VendorId);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Date);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ContractAmount);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ContractAmountDescription);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ContractPeriodFrom);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ScopeOfWork);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->BasicOfWorkExecution);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->PaymentMethod);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ImplementPeriode);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ImplementInsurrance);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Miscellanous);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ReceivedAgreement);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->ReceivedAgreementTitle);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Sender1Name);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Sender1Title);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Sender2Name);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Sender2Title);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->CreatedDate);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->CreatedByUserId);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->LastChangedDate);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->LastChangedByUserId);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->DeletedDate);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->DeletedUserId);

      	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function report($id){
      $this->load->library('m_pdf');
      if(!$id){
  			show_404();
  		}

      $data = $this->Agreement_model->getReportDetail($id);
      $AmountDescription = $this->Agreement_model->getAmountDescription($id);

      // print_r($data);
      // exit;


      ob_start();
        $this->load->view('report/agrrement',array('data' => $data, 'AmountDescription' => $AmountDescription, 'ProyekName' => $this->_strProyekName, 'ProyekAddress' => $this->_strProyeAddress));
        $html = ob_get_contents();
			ob_end_clean();

      $pdf = new mPDF('utf-8', 'A4');
			$pdf->AddPage('P');
			$pdf->WriteHtml($html);
			$pdf->Output('test.pdf', 'I');
    }

    public function ListData(){
        $sql = "SELECT b.AgreementTypeName, c.VendorName, a.ContractNo, a.AgreementId, a.Date, a.ContractPeriodFrom, 
                        a.ContractPeriodTo, a.ContractAmount,
                        (select sum(Amount) from seqvaluedescription where AgreementId = a.AgreementId) NK
                    FROM trnagreement a LEFT JOIN mstagreementtype b ON b.AgreementTypeId=a.AgreementTypeId 
                    LEFT JOIN mstvendor c ON c.VendorId=a.VendorId 
                    WHERE a.DeletedDate IS NULL ";

        $column_order = array( 
          'a.ContractNo',
          'b.AgreementTypeName',
          'a.ContractNo',
          'c.VendorName', 
          'a.Date',
          'a.ContractAmount',
          'a.ContractNo',
          'a.ContractNo'
        );
        
        $column_search = array(
          'b.AgreementTypeName',
          'a.ContractNo',
          'c.VendorName', 
          'a.Date',
          'a.ContractAmount'
        ); 
        $order = array('b.AgreementTypeName' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val->AgreementTypeName;
            $row[] = $val->ContractNo;
            $row[] = $val->VendorName;
            $row[] = date("d F Y", strtotime($val->Date));
            $row[] = number_format($val->NK, 0, '.', ',');
            $row[] = '<a href="#" id="print" onclick="javascript:modalPrint(\''.$val->AgreementId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak SPB SPJB"></i>
                      </a>
                      '.
                      anchor(
                        site_url('agreement/read/'.$val->AgreementId),
                        '<i class="glyphicon glyphicon-eye-open"></i>',
                        array('title'=>'detail')
                      ).' '.
                     anchor(
                        site_url('agreement/update/'.$val->AgreementId),
                        '<i class="glyphicon glyphicon-pencil"></i>',
                        array('title'=>'edit')
                      );
            
            $data[] = $row;
        }

        $Result = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->ListDataModel->count_all($sql),
                    "recordsFiltered" => $this->ListDataModel->count_filtered($sql, $column_search, $column_order, $order),
                    "data" => $data,
        );
    //keluarin pake json format
    echo json_encode($Result);
  }

}

/* End of file Agreement.php */
/* Location: ./application/controllers/Agreement.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-13 13:59:34 */
/* http://harviacode.com */
