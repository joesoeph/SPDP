<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PenerimaanInvoice extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('PenerimaanInvoice_model', 'Proyek_model', 'GlobalModel','ListDataModel'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/penerimaanInvoiceList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[8]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }

      $this->Layouts($Datas);
    }

    public function Accept()
    {
      $this->Content = 'content/penerimaanInvoiceAcceptList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[8]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }

      $this->Layouts($Datas);
    }

    public function Reject()
    {
      $this->Content = 'content/penerimaanInvoiceRejectList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[8]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      }

      $this->Layouts($Datas);
    }

    public function PendingDocument()
    {
      $this->Content = 'content/penerimaanInvoiceListPendingDocument';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[8]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->PenerimaanInvoice_model->get_pendingDocument();
      }
      $this->Layouts($Datas);
    }

    public function PendingVerification()
    {
      $this->Content = 'content/penerimaanInvoiceListPendingVerification';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[8]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->PenerimaanInvoice_model->get_pendingVerification();
      }
      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/penerimaanInvoiceForm';
      $Datas['AddCss'] = ['assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css'];
      $Datas['AddJsHeader'] = ['assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js'];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js',
      ];

      $row = $this->PenerimaanInvoice_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[8]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('penerimaanInvoice/create_action'),
          		'PenerimaanInvoiceId' => $row->PenerimaanInvoiceId,
          		'ProyekId' => $row->ProyekId,
              'VendorId' => $row->VendorId,
          		'InvoiceNo' => $row->InvoiceNo,
          		'InvoiceDate' => $row->InvoiceDate,
          		'FakturNo' => $row->FakturNo,
          		'NpwpNo' => $row->NpwpNo,
          		'RealCost' => $row->RealCost,
          		'PpnId' => $row->PpnId,
          		'PphId' => $row->PphId,
              'BillTypeId' => $row->BillTypeId,
          		'TotalValue' => $row->TotalValue,
          		'BuktiNo' => $row->BuktiNo,
          		'ReceivedId' => $row->ReceivedId,
          		'ReceivedDate' => $row->ReceivedDate,
          		'SenderId' => $row->SenderId,
          		'OtherSenderName' => $row->OtherSenderName,
              'OtherSenderTelp' => $row->OtherSenderTelp,
              'AccountNumber' => $row->AccountNumber,
          		'AccountByName' => $row->AccountByName,
              'CreatedDate' => $row->CreatedDate,
          		'CreatedByUserId' => $row->CreatedByUserId,
          		'LastChangedDate' => $row->LastChangedDate,
          		'LastChangedByUserId' => $row->LastChangedByUserId,
          		'DeletedDate' => $row->DeletedDate,
          		'DeletedUserId' => $row->DeletedUserId,
          	);
            $Datas['DataVendor'] = $this->PenerimaanInvoice_model->vendorSelected($id);
            $Datas['DataProyek'] = $this->PenerimaanInvoice_model->proyekSelected($id);
            $Datas['DataPpn'] = $this->PenerimaanInvoice_model->ppnSelected($id);
            $Datas['DataPph'] = $this->PenerimaanInvoice_model->pphSelected($id);
            $Datas['DataSender'] = $this->PenerimaanInvoice_model->senderSelected($id);
            $Datas['DataPaymentType'] = $this->PenerimaanInvoice_model->viewPaymentType($id);
            $Datas['DataBillType'] = $this->PenerimaanInvoice_model->viewBillType($id);
        }
        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('penerimaanInvoice'));
      }
    }

    public function create()
    {
      $this->Content = 'content/penerimaanInvoiceForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css',
        'assets/vendor/bootstrap-fileinput-master/css/fileinput.css',
        'assets/vendor/bootstrap-fileinput-master/themes/explorer/theme.css',
      ];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'assets/vendor/bootstrap-fileinput-master/js/plugins/sortable.js',
        'assets/vendor/bootstrap-fileinput-master/js/fileinput.js',
        'assets/vendor/bootstrap-fileinput-master/themes/explorer/theme.js',
      ];
      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js',
      ];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[8]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('penerimaanInvoice/create_action'),
      	    'PenerimaanInvoiceId' => set_value('PenerimaanInvoiceId'),
      	    'ProyekId' => set_value('ProyekId'),
            'VendorId' => set_value('VendorId'),
      	    'InvoiceNo' => set_value('InvoiceNo'),
      	    'InvoiceDate' => set_value('InvoiceDate'),
      	    'FakturNo' => set_value('FakturNo'),
      	    'NpwpNo' => set_value('NpwpNo'),
      	    'RealCost' => set_value('RealCost'),
      	    'PpnId' => set_value('PpnId'),
      	    'PphId' => set_value('PphId'),
            'BillTypeId' => set_value('BillTypeId'),
      	    'TotalValue' => set_value('TotalValue'),
      	    'BuktiNo' => set_value('BuktiNo'),
      	    'ReceivedId' => $this->session->userdata('user_id'),
      	    'ReceivedDate' => set_value('ReceivedDate'),
      	    'SenderId' => set_value('SenderId'),
      	    'OtherSenderName' => set_value('OtherSenderName'),
            'OtherSenderTelp' => set_value('OtherSenderTelp'),
            'AccountNumber' => set_value('AccountNumber'),
      	    'AccountByName' => set_value('AccountByName'),
      	    'KontrakNo' => set_value('KontrakNo'),
            'KontrakDate' => set_value('KontrakDate'),
      	    'KontrakDescription' => set_value('KontrakDescription'),
            'CreatedByUserId' => '',
            'CreatedDate' => '',
            'LastChangedDate' => '',
            'LastChangedByUserId' => '',
            'DeletedUserId' => '',
            'DeletedDate' => '',
      	);

        $Datas['DataVendor'] = $this->PenerimaanInvoice_model->vendorSelected();
        $Datas['DataProyek'] = $this->PenerimaanInvoice_model->proyekSelected();
        $Datas['DataPpn'] = $this->PenerimaanInvoice_model->ppnSelected();
        $Datas['DataPph'] = $this->PenerimaanInvoice_model->pphSelected();
        $Datas['DataSender'] = $this->PenerimaanInvoice_model->senderSelected();
        $Datas['DataPaymentType'] = $this->PenerimaanInvoice_model->viewPaymentType();
        $Datas['DataBillType'] = $this->PenerimaanInvoice_model->viewBillTypeAll();
      }

      $this->Layouts($Datas);
    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[8]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $PenerimaanInvoiceId = uniqid();
            $PenerimaanInvoiceId.= uniqid();
            $RealCost = explode(".",($this->input->post('RealCost',TRUE)));
            $RealCost = str_replace(",","",($RealCost[0]));
            $TotalValue = explode(".",($this->input->post('TotalValue',TRUE)));
            $TotalValue = str_replace(",","",($TotalValue[0]));

            $data = array(
              'PenerimaanInvoiceId' => $PenerimaanInvoiceId,
          		'ProyekId' => $this->input->post('ProyekId',TRUE),
              'VendorId' => $this->input->post('VendorId',TRUE),
          		'InvoiceNo' => $this->input->post('InvoiceNo',TRUE),
          		'InvoiceDate' => $this->input->post('InvoiceDate',TRUE),
          		'FakturNo' => $this->input->post('FakturNo',TRUE),
          		'NpwpNo' => $this->input->post('NpwpNo',TRUE),
          		'RealCost' => $RealCost,
          		'PpnId' => $this->input->post('PpnId',TRUE),
              'PphId' => $this->input->post('PphId',TRUE),
          		'BillTypeId' => $this->input->post('BillTypeId',TRUE),
          		'TotalValue' => $TotalValue,
          		'BuktiNo' => $this->input->post('BuktiNo',TRUE),
          		'ReceivedId' => $this->input->post('ReceivedId',TRUE),
          		'ReceivedDate' => $this->input->post('ReceivedDate',TRUE),
          		'SenderId' => $this->input->post('SenderId',TRUE),
          		'OtherSenderName' => $this->input->post('OtherSenderName',TRUE),
              'OtherSenderTelp' => $this->input->post('OtherSenderTelp',TRUE),
              'AccountNumber' => $this->input->post('AccountNumber',TRUE),
          		'AccountByName' => $this->input->post('AccountByName',TRUE),
              'PaymentTypeId' => $this->input->post('PaymentTypeId',TRUE),
                'KontrakNo' => $this->input->post('KontrakNo',TRUE),
                'KontrakDate' => $this->input->post('KontrakDate',TRUE),
      	        'KontrakDescription' => $this->input->post('KontrakDescription',TRUE),
              'CreatedDate' => date("Y-m-d H:i:s"),
              'CreatedByUserId' => $this->session->userdata('user_id')
        	  );

            $exst = $this->GlobalModel->getDataByWhere('trnpenerimaaninvoice', array('BuktiNo' => $this->input->post('BuktiNo',TRUE), 'BillTypeId' => $this->input->post('BillTypeId',TRUE)));
            if($exst){
              $this->session->set_flashdata('message', 'No urut sudah digunakan');
              redirect(site_url('PenerimaanInvoice/update/'.$exst->PenerimaanInvoiceId));
            }else{
              $NoUrut = $this->PenerimaanInvoice_model->getNoUrut($this->input->post('BillTypeId',TRUE));

              if($this->input->post('BuktiNo',TRUE) > $NoUrut->NoUrutMax){
                $this->session->set_flashdata('message', 'Nomor urut melebihi maksimal');
              }else{
                $this->PenerimaanInvoice_model->insert($data);
                //update sequencer no urut
                $this->PenerimaanInvoice_model->updateSeqNoUrut($this->input->post('BillTypeId',TRUE), $this->input->post('BuktiNo',TRUE));
                //
                $this->session->set_flashdata('message', 'Data disimpan');
                //redirect(site_url('penerimaanInvoice'));

                $subject = "Penerimaan Invoice Baru";

                //$this->send_email($data, $subject);
                $this->update($PenerimaanInvoiceId);
              }
              redirect(site_url('PenerimaanInvoice/update/'.$PenerimaanInvoiceId));
            }
          }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PenerimaanInvoice'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/penerimaanInvoiceDocumentForm';
      $Datas['AddCss'] = [
          'assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css',
          'assets/vendor/bootstrap-fileinput-master/css/fileinput.css',
          'assets/vendor/bootstrap-fileinput-master/themes/explorer/theme.css',
          'assets/signature/css/signature-pad.css',
        ];

      $Datas['AddJsHeader'] = [
          'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
          'assets/vendor/bootstrap-fileinput-master/js/plugins/sortable.js',
          'assets/vendor/bootstrap-fileinput-master/js/fileinput.js',
          'assets/vendor/bootstrap-fileinput-master/themes/explorer/theme.js',

        ];

      $Datas['AddJsFooter'] = [
        'assets/vendor/input-mask/js/inputmask.js',
        'assets/vendor/input-mask/js/inputmask.numeric.extensions.js',
        'assets/vendor/input-mask/js/jquery.inputmask.js',
        'assets/signature/js/signature_pad.js', 'assets/signature/js/app.js',
      ];

      $row = $this->PenerimaanInvoice_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[8]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $disabled = ($row->LockDate) ? "disabled" : "";
          
          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('penerimaanInvoice/update_action/'.$id),
            'attribute' => $disabled,
        		'PenerimaanInvoiceId' => set_value('PenerimaanInvoiceId', $row->PenerimaanInvoiceId),
        		'ProyekId' => set_value('ProyekId', $row->ProyekId),
            'VendorId' => set_value('VendorId', $row->ProyekId),
        		'InvoiceNo' => set_value('InvoiceNo', $row->InvoiceNo),
        		'InvoiceDate' => set_value('InvoiceDate', $row->InvoiceDate),
        		'FakturNo' => set_value('FakturNo', $row->FakturNo),
        		'NpwpNo' => set_value('NpwpNo', $row->NpwpNo),
        		'RealCost' => set_value('RealCost', $row->RealCost),
        		'PpnId' => set_value('PpnId', $row->PpnId),
            'PphId' => set_value('PphId', $row->PphId),
        		'BillTypeId' => set_value('BillTypeId', $row->BillTypeId),
        		'TotalValue' => set_value('TotalValue', $row->TotalValue),
        		'BuktiNo' => set_value('BuktiNo', $row->BuktiNo),
        		'ReceivedId' => set_value('ReceivedId', $row->ReceivedId),
        		'ReceivedDate' => set_value('ReceivedDate', $row->ReceivedDate),
        		'SenderId' => set_value('SenderId', $row->SenderId),
        		'OtherSenderName' => set_value('OtherSenderName', $row->OtherSenderName),
            'OtherSenderTelp' => set_value('OtherSenderTelp', $row->OtherSenderTelp),
            'AccountNumber' => set_value('AccountNumber', $row->AccountNumber),
        	'AccountByName' => set_value('AccountByName', $row->AccountByName),
        		'KontrakNo' => set_value('KontrakNo', $row->KontrakNo,TRUE),
                'KontrakDate' => set_value('KontrakDate', $row->KontrakDate,TRUE),
      	        'KontrakDescription' => set_value('KontrakDescription', $row->KontrakDescription,TRUE),
            'CreatedByUserId' => $row->CreatedByUserId,
            'CreatedDate' => $row->CreatedDate,
            'LastChangedDate' => $row->LastChangedDate,
            'LastChangedByUserId' => $row->LastChangedByUserId,
            'DeletedUserId' => $row->DeletedUserId,
            'DeletedDate' => $row->DeletedDate,
            'LockDate' => $row->LockDate,
            'LockByUserId' => $row->LockByUserId,
            
    	    );
          $Datas['DataVendor'] = $this->PenerimaanInvoice_model->vendorSelected($id);
          $Datas['DataProyek'] = $this->PenerimaanInvoice_model->proyekSelected($id);
          $Datas['DataPpn'] = $this->PenerimaanInvoice_model->ppnSelected($id);
          $Datas['DataPph'] = $this->PenerimaanInvoice_model->pphSelected($id);
          $Datas['DataSender'] = $this->PenerimaanInvoice_model->senderSelected($id);
          $Datas['DataPaymentType'] = $this->PenerimaanInvoice_model->viewPaymentType($id);
          $Datas['DataBillType'] = $this->PenerimaanInvoice_model->viewBillType($id);

          $ao = new ArrayObject();
          $ao ->setFlags(ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS);
          $ao->BillTypeId = $row->BillTypeId;
          $tempArr = array(
            0 => $ao,
          );
          foreach ($tempArr as $Val) {
            $Val->DocumentGroup = $this->PenerimaanInvoice_model->getDocumentByPenerimaanInvoiceId($id, $Val->BillTypeId);
          }

          $Datas['DataGrpBillDocument'] = $tempArr;
          $Datas['DataIsVerifStatus'] = $this->PenerimaanInvoice_model->getIsVerifStatusByPenerimaanInvoiceId($id);
          $Datas['DataVerificator'] = $this->PenerimaanInvoice_model->getVerificatorByPenerimaanInvoiceId($id);
          $Datas['DataDocumentStatus'] = $this->PenerimaanInvoice_model->getDocumentStatusByPenerimaanInvoiceId($id);
          $Datas['DataPenerimaanInvoiceStatus'] = $this->PenerimaanInvoice_model->getPenerimaanInvoiceStatusByPenerimaanInvoiceId($id);
          $Datas['DataCompleteVerification'] = $this->PenerimaanInvoice_model->cekCompletedDocumentVerification($id, $this->session->userdata('jabatanid'));
        }
        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('PenerimaanInvoice'));
      }

    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[8]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $RealCost = explode(".",($this->input->post('RealCost',TRUE)));
            $RealCost = str_replace(",","",($RealCost[0]));
            $TotalValue = explode(".",($this->input->post('TotalValue',TRUE)));
            $TotalValue = str_replace(",","",($TotalValue[0]));

            $data = array(
          		'ProyekId' => $this->input->post('ProyekId',TRUE),
              'VendorId' => $this->input->post('VendorId',TRUE),
          		'InvoiceNo' => $this->input->post('InvoiceNo',TRUE),
          		'InvoiceDate' => $this->input->post('InvoiceDate',TRUE),
          		'FakturNo' => $this->input->post('FakturNo',TRUE),
          		'NpwpNo' => $this->input->post('NpwpNo',TRUE),
          		'RealCost' => $RealCost,
          		'PpnId' => $this->input->post('PpnId',TRUE),
          		'PphId' => $this->input->post('PphId',TRUE),
              'BillTypeId' => $this->input->post('BillTypeId',TRUE),
          		'TotalValue' => $TotalValue,
          		'BuktiNo' => $this->input->post('BuktiNo',TRUE),
          		'ReceivedId' => $this->input->post('ReceivedId',TRUE),
          		'ReceivedDate' => $this->input->post('ReceivedDate',TRUE),
          		'SenderId' => $this->input->post('SenderId',TRUE),
          		'OtherSenderName' => $this->input->post('OtherSenderName',TRUE),
              'OtherSenderTelp' => $this->input->post('OtherSenderTelp',TRUE),
              'AccountNumber' => $this->input->post('AccountNumber',TRUE),
          		'AccountByName' => $this->input->post('AccountByName',TRUE),
          		'KontrakNo' => $this->input->post('KontrakNo',TRUE),
                'KontrakDate' => $this->input->post('KontrakDate',TRUE),
      	        'KontrakDescription' => $this->input->post('KontrakDescription',TRUE),
              'PaymentTypeId' => $this->input->post('PaymentTypeId',TRUE),
              'LastChangedDate' => date("Y-m-d H:i:s"),
              'LastChangedByUserId' => $this->session->userdata('user_id')
          	);

            //update sequencer no urut
            //$this->PenerimaanInvoice_model->updateSeqNoUrut($this->input->post('BillTypeId',TRUE), $this->input->post('BuktiNo',TRUE));
            //
            $this->PenerimaanInvoice_model->update($id, $data);

            //$subject = "Pembaruan Invoice";
            //$a = $this->PenerimaanInvoice_model->send_email_update($id);
            //$this->send_email($data, $subject);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('PenerimaanInvoice/update/'.$id));
            // redirect(site_url('PenerimaanInvoice'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PenerimaanInvoice'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[8]['Delete']){
        $row = $this->PenerimaanInvoice_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date('Y-m-d H:i:s'),
                    'DeletedUserId' => $this->session->userdata('user_id')
                  );

          $this->PenerimaanInvoice_model->update($row->PenerimaanInvoiceId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Penerimaaninvoice'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Penerimaaninvoice'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PenerimaanInvoice'));
      }
    }

    public function InvoiceVerification($id = NULL){
      if($this->input->post('InvoiceVerificationStatus', TRUE)){
        $data = array(
          'PenerimaanInvoiceId' => $id,
          'JabatanId' => $this->session->userdata('jabatanid'),
          'Status' => $this->input->post('InvoiceVerificationStatus', TRUE),
          'Note' => $this->input->post('InvoiceVerificationNote', TRUE),
          'StatusDate' => date("Y-m-d H:i:s"),
          'StatusByUserId' => $this->session->userdata('user_id')
        );
        $res = $this->PenerimaanInvoice_model->InvoiceVerification($id, $this->session->userdata('jabatanid'), $data);
        if($res){
          $res = array('status' => TRUE, 'message' => 'Verifikasi sukses');
          // $this->session->set_flashdata('message', 'Verifikasi sukses');
        }else{
          $res = array('status' => FALSE, 'message' => 'Verifikasi gagal');
          // $this->session->set_flashdata('message', 'Verifikasi gagal');
        }
        // redirect(site_url('PenerimaanInvoice/update/'.$id));
      }
      echo json_encode($res);
    }

    public function _rules()
    {
      $this->form_validation->set_rules('ProyekId', ' ', 'trim|required');
      $this->form_validation->set_rules('BillTypeId', ' ', 'trim|required');
    	$this->form_validation->set_rules('VendorId', ' ', 'trim|required');
    	$this->form_validation->set_rules('InvoiceNo', ' ', 'trim|required');
    	$this->form_validation->set_rules('InvoiceDate', ' ', 'trim|required');
    	//$this->form_validation->set_rules('FakturNo', ' ', 'trim|required');
    	//$this->form_validation->set_rules('NpwpNo', ' ', 'trim|required');
    	$this->form_validation->set_rules('RealCost', ' ', 'trim|required');
    	$this->form_validation->set_rules('PpnId', ' ', 'trim|required');
    	$this->form_validation->set_rules('PphId', ' ', 'trim|required');
    	$this->form_validation->set_rules('TotalValue', ' ', 'trim|required');

    	$this->form_validation->set_rules('PenerimaanInvoiceId', 'PenerimaanInvoiceId', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function report($id)
    {
      $this->load->library('pdf');

      $data = $this->PenerimaanInvoice_model->getDetailReport($id);

      $RealCost = number_format($data->RealCost,0,",",".");
      $PpnValue = number_format((($data->RealCost * $data->PpnValue)/100),0,",",".");
      $PphValue = number_format((($data->RealCost * $data->PphValue)/100),0,",",".");
      $TotalValue = number_format($data->TotalValue,0,",",".");

      global $title;
      $fpdf = new PDF('L', 'cm', 'A4');
      $title = 'Penerimaan Tagihan';
      $fpdf->SetTitle($title);
      $fpdf->AliasNbPages();
      $fpdf->AddPage();
      $fpdf->Ln();
      $fpdf->SetTextColor(0, 0, 0);
      $fpdf->setFont('Arial', 'B', 10);
      $fpdf->SetX(1);
      $fpdf->SetY(1);
      $fpdf->Image(base_url('assets/Logo-PP.jpg'),1,1,-1000);
      $fpdf->SetY(4);
      $fpdf->Cell(4, 1, 'NAMA PROYEK', 'LTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->ProyekName, 'RTB', 0, '');

      $fpdf->SetY(4);
      $fpdf->SetX(17.5);
      $fpdf->Cell(3, 1, 'KODE PROYEK', 'LRTB', 0, 'C');
      $fpdf->Cell(3, 1, 'NO. BUKTI', 'LRTB', 0, 'C');
      $fpdf->SetY(5);
      $fpdf->SetX(17.5);
      $fpdf->Cell(3, 1.3, $data->ProyekCode, 'LRTB', 0, 'C');
      $fpdf->Cell(3, 1.3, $data->BuktiNo, 'LRTB', 0, 'C');

      $fpdf->SetY(5.2);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'NAMA VENDOR', 'LTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->VendorName, 'RTB', 0, '');

      $fpdf->SetY(6.4);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'NO INVOICE', 'LTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->InvoiceNo, 'RTB', 0, '');

      $fpdf->SetY(7.6);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'TGL INVOICE', 'LTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->InvoiceDate, 'RTB', 0, '');

      $fpdf->SetY(8.8);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'NO FAKTUR PAJAK', 'LTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->FakturNo, 'RTB', 0, '');

      $fpdf->SetY(10);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'NO NPWP', 'LTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->NpwpNo, 'RTB', 0, '');

      $fpdf->SetY(11.2);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'NO REKENING', 'LTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->AccountNumber, 'RTB', 0, '');

      $fpdf->SetY(12.4);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'A/N', 'LTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->AccountByName, 'RTB', 0, '');

      $fpdf->SetY(13.6);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'TIPE PEMBAYARAN', 'LTB', 0, '');
      //$fpdf->Cell(12, 1, ': ('.$data->PaymentTypeCode.') '.$data->PaymentTypeName, 'RTB', 0, '');
      $fpdf->Cell(12, 1, ': '.$data->PaymentTypeCode, 'RTB', 0, '');    

      $fpdf->setFont('Arial', 'B', 9);
      $fpdf->SetY(14.8);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 1, 'REAL COST', 'LRTB', 0, 'C');
      $fpdf->Cell(4, 1, 'PPN '.$data->PpnValue.'%', 'LRTB', 0, 'C');
      $fpdf->Cell(4, 1, 'PPH '.$data->PphValue.'%', 'LRTB', 0, 'C');
      $fpdf->Cell(4, 1, 'NILAI REAL COST + PPN', 'LRTB', 0, 'C');

      $fpdf->SetY(15.8);
      $fpdf->SetX(1);
      $fpdf->Cell(4, 2, $RealCost, 'LRTB', 0, 'C');
      $fpdf->Cell(4, 2, $PpnValue, 'LRTB', 0, 'C');
      $fpdf->Cell(4, 2, $PphValue, 'LRTB', 0, 'C');
      $fpdf->Cell(4, 2, $TotalValue, 'LRTB', 0, 'C');

      $fpdf->setFont('Arial', 'B', 9, 'button');
      $fpdf->Text(17.5, 6.7, 'NAMA PENERIMA');

      $fpdf->setFont('Arial', 'B', 9);
      $fpdf->SetY(6.8);
      $fpdf->SetX(17.5);
      $fpdf->Cell(6, 1, $data->name, 'LRTB', 0, '');

      $fpdf->setFont('Arial', 'B', 9, 'button');
      $fpdf->Text(17.5, 8.2, 'TANGGAL DITERIMA');
      $fpdf->SetY(8.3);
      $fpdf->SetX(17.5);
      $fpdf->Cell(6, 1, $data->ReceivedDate, 'LRTB', 0, '');

      $fpdf->setFont('Arial', 'B', 9, 'button');
      $fpdf->Text(17.5, 9.7, 'PENGIRIM');
      $fpdf->SetY(9.8);
      $fpdf->SetX(17.5);
      $fpdf->Cell(6, 1, $data->SenderName, 'LRTB', 0, '');
      
      $fpdf->setFont('Arial', 'B', 9, 'button');
      $fpdf->Text(17.5, 11.2, 'NAMA PENGIRIM');
      $fpdf->SetY(11.3);
      $fpdf->SetX(17.5);
      $fpdf->Cell(6, 1, $data->OtherSenderName, 'LRTB', 0, '');
      
      $fpdf->setFont('Arial', 'B', 9, 'button');
      $fpdf->Text(17.5, 12.7, 'TELP');
      $fpdf->SetY(12.8);
      $fpdf->SetX(17.5);
      $fpdf->Cell(6, 1, $data->OtherSenderTelp, 'LRTB', 0, '');

      $fpdf->Output();
    }

    function reportCheckList($id)
    {
    $this->load->library('pdf');

    $DataPenerimaanInvoice = $this->PenerimaanInvoice_model->getPenerimaanInvoiceByPenerimaanInvoiceId($id);
    $DataDocumentStatus = $this->PenerimaanInvoice_model->getSeqPenerimaanInvoiceDocumentById($id);
    $DataVerificator = $this->PenerimaanInvoice_model->getVerificatorByPenerimaanInvoiceId($id);
    $DataVerificationStatus = $this->PenerimaanInvoice_model->getSeqPenerimaanInvoiceVerificationById($id);
    //echo "<pre>"; var_dump($DataPenerimaanInvoice);exit();
    if ($DataPenerimaanInvoice)
    {
        $ProyekName = strtoupper($DataPenerimaanInvoice->ProyekName);
        $ProyekCode = strtoupper($DataPenerimaanInvoice->ProyekCode);
        $BillTypeName = strtoupper($DataPenerimaanInvoice->BillTypeName);
        $BillTypeCode = strtoupper($DataPenerimaanInvoice->BillTypeCode);
        $BuktiNo = strtoupper($DataPenerimaanInvoice->BuktiNo);
        $InvoiceNo = strtoupper($DataPenerimaanInvoice->InvoiceNo);
        $InvoiceDate = $DataPenerimaanInvoice->InvoiceDate;
        $FakturNo = strtoupper($DataPenerimaanInvoice->FakturNo);
        $NpwpNo = strtoupper($DataPenerimaanInvoice->NpwpNo);
        $VendorName = strtoupper($DataPenerimaanInvoice->VendorName);
        $PpnName = strtoupper($DataPenerimaanInvoice->PpnName);
        $PpnValue = $DataPenerimaanInvoice->PpnValue.'%';
        $AccountNumber = $DataPenerimaanInvoice->AccountNumber;
        $AccountByName = $DataPenerimaanInvoice->AccountByName;
        $PphName = $DataPenerimaanInvoice->PphName;
        $PphValue = $DataPenerimaanInvoice->PphValue.'%';

        $PaymentTypeCode = $DataPenerimaanInvoice->PaymentTypeCode;
        $PaymentTypeName = $DataPenerimaanInvoice->PaymentTypeName;
        $RealCost = number_format($DataPenerimaanInvoice->RealCost);
        $TotalValue = number_format($DataPenerimaanInvoice->TotalValue);
        $PpnCost = number_format($DataPenerimaanInvoice->RealCost * ($DataPenerimaanInvoice->PpnValue/100));
        $PphCost = number_format($DataPenerimaanInvoice->RealCost * ($DataPenerimaanInvoice->PphValue/100));

    }

    global $title;
    $fpdf = new PDF('P', 'cm', 'A4');
    $title = 'Check List Tagihan';
    $fpdf->SetTitle($title);
    $fpdf->AliasNbPages();
    $fpdf->AddPage();
    $fpdf->Ln();
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->setFont('Arial', 'B', 12);
    $fpdf->SetX(1);
    $fpdf->SetY(1);
    $fpdf->Text(8, 1, 'CHECKLIST TAGIHAN '.$BillTypeName);
    $fpdf->Text(9.5, 1.5, 'REGULER/SKBDN');

    $fpdf->setFont('Arial', 'B', 10);
    $fpdf->SetY(2);
    $fpdf->Cell(4, 1, 'NAMA PROYEK', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$ProyekName, 'RTB', 0, '');

    $fpdf->SetY(2);
    $fpdf->SetX(14);
    $fpdf->Cell(3, 1, 'KODE PROYEK', 'LRTB', 0, 'C');
    $fpdf->Cell(3, 1, 'NO. BUKTI', 'LRTB', 0, 'C');
    $fpdf->SetY(3);
    $fpdf->SetX(14);
    $fpdf->Cell(3, 1.3, $ProyekCode, 'LRTB', 0, 'C');
    $fpdf->Cell(3, 1.3, $BillTypeCode.$BuktiNo, 'LRTB', 0, 'C');

    $fpdf->SetY(3.2);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NAMA VENDOR', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$VendorName, 'RTB', 0, '');

    $fpdf->SetY(4.4);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NO INVOICE', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$InvoiceNo, 'RTB', 0, '');

    $fpdf->SetY(5.6);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'TGL INVOICE', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$InvoiceDate, 'RTB', 0, '');

    $fpdf->SetY(6.8);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NO FAKTUR PAJAK', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$FakturNo, 'RTB', 0, '');

    $fpdf->SetY(8);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NO NPWP', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$NpwpNo, 'RTB', 0, '');

    $fpdf->SetY(9.2);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NO REKENING', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$AccountNumber, 'RTB', 0, '');

    $fpdf->SetY(10.4);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'A/N', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$AccountByName, 'RTB', 0, '');

    $fpdf->SetY(11.6);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'TIPE PEMBAYARAN', 'LTB', 0, '');
    $fpdf->Cell(8.5, 1, ': '.$PaymentTypeCode.' ('.$PaymentTypeName.')', 'RTB', 0, '');

    $fpdf->setFont('Arial', 'B', 9);
    $fpdf->SetY(12.8);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'REAL COST', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, $PpnName.' '.$PpnValue, 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, 'PPH '.$PphValue, 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, 'NILAI REAL COST', 'LRTB', 0, 'C');

    $fpdf->SetY(13.8);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, $RealCost, 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, $PpnCost, 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, $PphCost, 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, $TotalValue, 'LRTB', 0, 'C');

    $fpdf->setFont('Arial', 'BU', 9, 'button');
    $fpdf->Text(14, 5, 'CHECKLIST KELENGKAPAN BERKAS');
    $setY = 5.6;
    $Ylog = 6;
    foreach ($DataDocumentStatus as $Val) {
      $ExistDoc = ($Val->Path) ? 'X' : '';
      $fpdf->setFont('Arial', 'B', 9, 'button');
      $fpdf->SetY($setY);
      $fpdf->SetX(14);
      $fpdf->Cell(0.5, 0.5, $ExistDoc, 'LRTB', 0, '');
      $fpdf->Text(15, $Ylog, $Val->DocumentName);
      $setY += 0.6;
      $Ylog += 0.6;
    }

    $fpdf->SetY(15);
    $fpdf->SetX(1);
    $fpdf->Cell(3, 0.7, 'DIVERIFIKASI', 'LRTB', 0, 'C');
    $fpdf->Cell(3, 0.7, 'TGL', 'LRTB', 0, 'C');
    $fpdf->Cell(3, 0.7, 'PARAF', 'LRTB', 0, 'C');
    $fpdf->Cell(1.5, 0.7, 'YES', 'LRTB', 0, 'C');
    $fpdf->Cell(1.5, 0.7, 'NO', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 0.7, 'KETERANGAN', 'LRTB', 0, 'C');

    $setY = 15.7;
    $setYttd = 15.8;
    foreach ($DataVerificator as $Val) {

      $DataCompleteVerification = $this->PenerimaanInvoice_model->cekCompletedDocumentVerification($id, $Val->JabatanId);
      $StatusDate = ($DataCompleteVerification->StatusDate ? date("Y-m-d", strtotime($DataCompleteVerification->StatusDate)) : "");
      $Note = $DataCompleteVerification->Note;
      $Diterima = ($DataCompleteVerification->Status == 1 ? "X" : "");
      $Ditolak = ($DataCompleteVerification->Status == 2? "X" : "");
      $TtdHard = ($DataCompleteVerification->TtdHard != NULL? $DataCompleteVerification->TtdHard : NULL);

      $fpdf->SetY($setY);
      $fpdf->SetX(1);
      $fpdf->Cell(3, 1, $Val->JabatanCode, 'LRTB', 0, 'C');
      $fpdf->Cell(3, 1, $StatusDate, 'LRTB', 0, 'C');
      $fpdf->Cell(3, 1, '', 'LRTB', 0, 'C');
      //if ($TtdHard != null): $fpdf->Image(base_url('upload/ttd/'.$TtdHard),8,$setYttd,0,0.8);
      //endif;
      if ($DataCompleteVerification->Ttd)
      {
        $path = $_SERVER['DOCUMENT_ROOT'].'/upload/tempsign/';
        $filename = $DataPenerimaanInvoice->PenerimaanInvoiceId.'_'.$DataCompleteVerification->JabatanId.'.png';
        $filepath = $path.$filename;
        
        $dataURI = $DataCompleteVerification->Ttd;  
        $dataPieces = explode(',',$dataURI);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);
        
        //  Check if image was properly decoded
        if( $decodedImg!==false )
        {
            //  Save image to a temporary location
            if( file_put_contents($filepath, $decodedImg)!==false )
            {
                $fpdf->Image($filepath, 8, $setYttd, 0, 0.8); 

                //  Delete image from server
                unlink($filepath);
            }
        }
      }
    
      $fpdf->Cell(1.5, 1, $Diterima, 'LRTB', 0, 'C');
      $fpdf->Cell(1.5, 1, $Ditolak, 'LRTB', 0, 'C');
      $fpdf->Cell(4, 1, $Note, 'LRTB', 0, 'L');
      $setY += 1;
      $setYttd +=1;
    }

    $fpdf->Output();
  }

    function seqNoUrut(){
      $MinMax = $this->PenerimaanInvoice_model->getNoUrut($this->input->post('BillTypeId'));
      $NoUrut = $this->PenerimaanInvoice_model->getSeqNoUrut($MinMax->BillTypeId);
      if(!$NoUrut){
        $NoUrut = array(
          'NoUrut' => str_pad(($MinMax->NoUrutMin+1), 4, '0', STR_PAD_LEFT)
        );
      }else{
        $NoUrut = array(
          'NoUrut' => str_pad(($NoUrut->LastNo+1), 4, '0', STR_PAD_LEFT)
        );
      }
      echo json_encode($NoUrut);
      // return $NoUrut;
    }

    function getGrpBillDocumentByBillTypeIdAction(){
      $Data = $this->PenerimaanInvoice_model->getGrpBillDocumentByBillTypeId($this->input->post('BillTypeId'));
      echo json_encode($Data);
      // return $NoUrut;
    }

    function UploadDocument(){

      $BillDocument         =  $this->uri->segment(3);
      $PenerimaanInvoiceId  =  $this->uri->segment(4);

      $this->_rules();

      //echo var_dump($_FILES['file_'.$BillDocument]['name'], $_FILES, $BillDocument, $this->input->post());exit();

      //$dir_doc = base_url("assets/upload/");
       $dir_doc = $_SERVER['DOCUMENT_ROOT'].'/upload/';
    //   $dir_doc = $_SERVER['DOCUMENT_ROOT'].'/pp/upload/';
    	$filename = $_FILES['file_'.$BillDocument]['name'];
      //$filename = $this->file->post['file-'.$BillDocument]['name'];
    	$uniq1 = uniqid();
    	$uniq2 = uniqid();
    	if($this->input->post('hdnTemp'.$BillDocument.'_Id', true)=="") $filename_save = $uniq1.$uniq2;
      else $filename_save = "Doc_".$this->input->post('hdnTemp'.$BillDocument.'_Id', true)."_".$this->input->post('hdnTemp'.$BillDocument.'_BillTypeId', true)."_".$this->input->post('hdnTemp'.$BillDocument.'_DocumentId', true).$uniq1;

    	$ext = pathinfo( $filename, PATHINFO_EXTENSION );
    	$ekstensi = array('pdf'); // Ektensi yg diterima

      $html = "";

      //filter ektensi gambar yang diterima
      if( in_array($ext, $ekstensi ))
      {
        //maks ukuran gambar 500kb
        if($_FILES['file_'.$BillDocument]['size'] < 5000000)
        {
          $filename = "Document-" . time() . "." .$ext;
          if (move_uploaded_file( $_FILES['file_'.$BillDocument]['tmp_name'], $dir_doc . $filename_save. '.pdf' ))
          {
            $html = "<b><font color='green'><i>".$this->input->post('hdnTemp'.$BillDocument.'_DocumentName', true)." Berhasil diupload</i></font></b><input type='hidden' name='hdnStats".$BillDocument."' id='hdnStats".$BillDocument."' value='1'><br>";

            $data = array(
              'Path' => $filename_save.'.pdf',
              'UploadDate' => date("Y-m-d H:i:s"),
              'UploadByUserId' => $this->session->userdata('user_id'),
            );
            $this->PenerimaanInvoice_model->updateSeqPenerimaanInvoiceDocumentUpload($this->input->post('hdnTemp'.$BillDocument.'_Id', true), $this->input->post('hdnTemp'.$BillDocument.'_DocumentId', true), $data);

            $this->PenerimaanInvoice_model->updateSeqPenerimaanInvoiceDocumentStatusNull($this->input->post('hdnTemp'.$BillDocument.'_Id', true), $this->input->post('hdnTemp'.$BillDocument.'_DocumentId', true));

            // cek apakah dokument sudah diupload semua
            $CompleteUpload = $this->PenerimaanInvoice_model->cekCompletedUpload($PenerimaanInvoiceId);
            if($CompleteUpload->TotDocument == $CompleteUpload->TotDocumentUpload){
              //$this->send_email_upload(array('PenerimaanInvoiceId' => $PenerimaanInvoiceId), "Pemberitahuan kelengkapan upload dokumen penerimaan invoice");
            }

          }
          else $html = "<font color='red'><i>Gagal</i></font><input type='hidden' name='hdnStats".$BillDocument."' id='".$BillDocument."' value='0'>";
        }
        else $html = "<font color='red'><i>Ukuran Terlalu Besar</i></font><input type='hidden' name='hdnStats".$BillDocument."' id='".$BillDocument."' value='0'>";
      }
      else $html = "<font color='red'><i>file support hanya .pdf</i></font><input type='hidden' name='hdnStats".$BillDocument."' id='".$BillDocument."' value='0'>";

      echo  $html;
    }
    
    function UploadSsp(){
      $this->_rules();
      // $dir_doc = $_SERVER['DOCUMENT_ROOT'].'/upload/lampiran/';
      $dir_doc = './upload/lampiran/';
    	$filename = $_FILES['file_Ssp']['name'];

    	if($this->input->post('hdnSspPenerimaanInvoiceId', true)=="") $filename_save = "Not Available";
        else $filename_save = "Doc_".$this->input->post('hdnSspPenerimaanInvoiceId', true)."_Ssp_".uniqid();

    	$ext = pathinfo( $filename, PATHINFO_EXTENSION );
    	$ekstensi = array('pdf'); // Ektensi yg diterima

      $html = "";

      //filter ektensi gambar yang diterima
      if( in_array($ext, $ekstensi ))
      {
        //maks ukuran gambar 500kb
        if($_FILES['file_Ssp']['size'] < 5000000)
        {
          $filename = "Document-" . time() . "." .$ext;
          if (move_uploaded_file( $_FILES['file_Ssp']['tmp_name'], $dir_doc . $filename_save. '.pdf' ))
          {
            $html = "<b><font color='green'><i>SSP Berhasil diupload</i></font></b>";

            $data = array(
              'SspLocation' => $filename_save.'.pdf',
              'SspUploadDate' => date("Y-m-d H:i:s"),
              'SspUploadByUserId' => $this->session->userdata('user_id'),
            );
            $this->PenerimaanInvoice_model->updateSsp($this->input->post('hdnSspPenerimaanInvoiceId', true), $data);

          }
          else $html = "<font color='red'><i>Gagal</i></font>";
        }
        else $html = "<font color='red'><i>Ukuran Terlalu Besar</i>";
      }
      else $html = "<font color='red'><i>file support hanya .pdf</i>";

      echo  $html;
    }
    
    function UploadBuktiPotong(){
      //echo $this->input->post('hdnBuktiPotongPenerimaanInvoiceId', true); exit();
      $this->_rules();
       $dir_doc = $_SERVER['DOCUMENT_ROOT'].'/upload/lampiran/';
    	$filename = $_FILES['file_BuktiPotong']['name'];

    	if($this->input->post('hdnBuktiPotongPenerimaanInvoiceId', true)=="") $filename_save = "Not Available";
        else $filename_save = "Doc_".$this->input->post('hdnBuktiPotongPenerimaanInvoiceId', true)."_BuktiPotong_".uniqid();

    	$ext = pathinfo( $filename, PATHINFO_EXTENSION );
    	$ekstensi = array('pdf'); // Ektensi yg diterima

      $html = "";

      //filter ektensi gambar yang diterima
      if( in_array($ext, $ekstensi ))
      {
        //maks ukuran gambar 500kb
        if($_FILES['file_BuktiPotong']['size'] < 5000000)
        {
          $filename = "Document-" . time() . "." .$ext;
          if (move_uploaded_file( $_FILES['file_BuktiPotong']['tmp_name'], $dir_doc . $filename_save. '.pdf' ))
          {
            $html = "<b><font color='green'><i>Bukti Potong Berhasil diupload</i></font></b>";

            $data = array(
              'BuktiPotongLocation' => $filename_save.'.pdf',
              'BuktiPotongUploadDate' => date("Y-m-d H:i:s"),
              'BuktiPotongUploadByUserId' => $this->session->userdata('user_id'),
            );
            $this->PenerimaanInvoice_model->updateBuktiPotong($this->input->post('hdnBuktiPotongPenerimaanInvoiceId', true), $data);

          }
          else $html = "<font color='red'><i>Gagal</i></font>";
        }
        else $html = "<font color='red'><i>Ukuran Terlalu Besar</i>";
      }
      else $html = "<font color='red'><i>file support hanya .pdf</i>";

      echo  $html;
    }

    public function DocumentPenerimaanInvoice(){
        $PenerimaanInvoiceId = $this->input->post('PenerimaanInvoiceId');
        $DocumentId = $this->input->post('DocumentId');
        $Data = $this->PenerimaanInvoice_model->getSeqPenerimaanInvoiceVerificationByPenerimaanInvoiceIdByDocumentId($PenerimaanInvoiceId, $DocumentId);



        echo json_encode($Data, JSON_PRETTY_PRINT);
    }


    public function UpdateDocumentStatus($PenerimaanInvoiceId = NULL){

      if($PenerimaanInvoiceId || $this->input->post('Status'))
      {
          $Data = array(
            'Status' => $this->input->post('Status'),
            'Note' => $this->input->post('Note'),
            'VerificationDate' => date("Y-m-d H:i:s"),
            'UserVerification' => $this->session->userdata('user_id')
          );

          $this->PenerimaanInvoice_model->updateSeqPenerimaanInvoiceDocumentStatus($PenerimaanInvoiceId, $this->input->post('DocumentId'), $this->input->post('JabatanId'), $Data);

          echo "berhasil";
      }
      else
      {
         echo "gagal";
      }
    }

    public function send_email($data, $subject)
    {
      $this->load->library('email');
      
      $this->email->set_newline("\r\n"); 
      
      
        $PenerimaanInvoiceId = $data['PenerimaanInvoiceId'];
        $data = $this->PenerimaanInvoice_model->getPenerimaanInvoiceByPenerimaanInvoiceId($PenerimaanInvoiceId);    
        $to_v = $this->PenerimaanInvoice_model->email_to_verificator($PenerimaanInvoiceId);
        
        $to = '';
        foreach ($to_v as $k) 
        {
            $to .= $k['email'].',';
        }

      $send_to = rtrim($to, ",");
      
      $set_message = "
        Info penerimaan invoice nomor bukti ".$data->BillTypeCode.$data->BuktiNo." nomor invoice ".$data->InvoiceNo." dari ".$data->VendorName." menunngu untuk diverifikasi.
      ".$this->_strGoToUrl;
        
      $this->email->subject($subject);
      $this->email->message($set_message);
      
      $this->email->from($this->_strEmailFrom, $this->_strEmailFromAlias);
      $this->email->to($send_to);    

	  
	  $status = "";
        if(!$this->email->send()) {
            $status = $this->email->print_debugger(); 
        } else {
            $status = "Message sent correctly!";
        }
    }

    public function send_email_upload($data = null, $subject = null)
    {
      $this->load->library('email');
      
      $this->email->set_newline("\r\n"); 
      
        $PenerimaanInvoiceId = $data['PenerimaanInvoiceId'];
        $data = $this->PenerimaanInvoice_model->getPenerimaanInvoiceByPenerimaanInvoiceId($PenerimaanInvoiceId);    
        $to_v = $this->PenerimaanInvoice_model->email_to_verificator($PenerimaanInvoiceId);
        
        $to = '';
        foreach ($to_v as $k) 
        {
            $to .= $k['email'].',';
        }

      $send_to = rtrim($to, ",");
      
      $set_message = "
        Dokumen penerimaan invoice dengan nomor bukti ".$data->BillTypeCode.$data->BuktiNo." nomor invoice ".$data->InvoiceNo." telah diupload.
      ".$this->_strGoToUrl;
        
      $this->email->subject($subject);
      $this->email->message($set_message);
      
      $this->email->from($this->_strEmailFrom, $this->_strEmailFromAlias);
      $this->email->to($send_to);    

	  
	  $status = "";
        if(!$this->email->send()) {
            $status = $this->email->print_debugger(); 
        } else {
            $status = "Message sent correctly!";
        }
        
    }

    public function ListData(){
        $sql = "SELECT a.*, b.ProyekCode, b.ProyekName, c.VendorName, d.BillTypeCode, d.BillTypeName, e.PaymentTypeCode, 
                        e.PaymentTypeName, f.PpnName, f.PpnValue, g.PphName, g.PphValue, h.name as ReceivedByName, a.LockDate 
                  FROM trnpenerimaaninvoice a LEFT JOIN trnproyek b ON b.ProyekId = a.ProyekId 
                  LEFT JOIN mstvendor c ON c.VendorId = a.VendorId 
                  LEFT JOIN mstbilltype d ON d.BillTypeId = a.BillTypeId 
                  LEFT JOIN mstpaymenttype e ON e.PaymentTypeId = a.PaymentTypeId 
                  LEFT JOIN mstppntagihan f ON f.PpnId = a.PpnId 
                  LEFT JOIN mstpphtagihan g ON g.PphId = a.PphId 
                  LEFT JOIN users h on a.ReceivedId = h.id
                WHERE a.DeletedDate IS NULL";

        $column_order = array( 
          'd.BillTypeCode',
          'a.BuktiNo',
          'a.InvoiceNo',
          'c.VendorName',
          'a.ReceivedDate',
          'h.name', 
          'a.LockDate',
          'a.BuktiNo',
        );
        
        $column_search = array(
          'd.BillTypeCode',
          'a.BuktiNo',
          'a.InvoiceNo',
          'c.VendorName',
          'a.ReceivedDate',
          'h.name', 
          'a.LockDate',
        ); 

        $order = array('a.BuktiNo' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $val->BillTypeCode.$val->BuktiNo;
            $row[] = $val->InvoiceNo;
            $row[] = $val->VendorName;
            $row[] = date("d F Y", strtotime($val->ReceivedDate));
            $row[] = $val->ReceivedByName;
            $row[] = ($val->LockDate) ? date("d M Y", strtotime($val->LockDate)) : "";
            //$row[] = date("d F Y", strtotime($val->InvoiceDate));
            $row[] = '<a href="#" id="print" onclick="javascript:modalPrint(\''.$val->PenerimaanInvoiceId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak Penerimaan Invoice"></i>
                      </a>
                      '.anchor(
                        site_url('PenerimaanInvoice/read/'.$val->PenerimaanInvoiceId),
                        '<i class="glyphicon glyphicon-eye-open"></i>',
                        array('title'=>'detail')
                      ).' '.
                     anchor(
                        site_url('PenerimaanInvoice/update/'.$val->PenerimaanInvoiceId),
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
    
    public function ListDataPendingVerification(){
        $sql = "SELECT DISTINCT(a.PenerimaanInvoiceId), a.*, b.ProyekCode, b.ProyekName, c.VendorName, d.BillTypeCode, 
                       d.BillTypeName, e.PaymentTypeCode, e.PaymentTypeName, f.PpnName, f.PpnValue, g.PphName, g.PphValue 
                       ,(
                            SELECT GROUP_CONCAT(mstjabatan.JabatanCode SEPARATOR ', ')
                            FROM seqpenerimaaninvoicestatus
                            JOIN mstjabatan on seqpenerimaaninvoicestatus.JabatanId = mstjabatan.JabatanId
                            WHERE seqpenerimaaninvoicestatus.Status = 0 
                            	AND seqpenerimaaninvoicestatus.PenerimaanInvoiceId =  a.PenerimaanInvoiceId
                            GROUP BY seqpenerimaaninvoicestatus.PenerimaanInvoiceId
                        ) PendingBy, h.name AS ReceivedByName
                FROM    (
                        SELECT PenerimaanInvoiceId, count(PenerimaanInvoiceId)
                        FROM
                        (
                        	select distinct(PenerimaanInvoiceId) FROM seqpenerimaaninvoicestatus WHERE Status = 0
                        	UNION ALL select distinct(PenerimaanInvoiceId) FROM seqpenerimaaninvoicestatus WHERE Status = 2
                        ) temp
                        GROUP BY PenerimaanInvoiceId
                        HAVING count(PenerimaanInvoiceId) = 1
                        ) w  
                JOIN trnpenerimaaninvoice a ON w.PenerimaanInvoiceId=a.PenerimaanInvoiceId 
                LEFT JOIN trnproyek b ON b.ProyekId = a.ProyekId 
                LEFT JOIN mstvendor c ON c.VendorId = a.VendorId 
                LEFT JOIN mstbilltype d ON d.BillTypeId = a.BillTypeId 
                LEFT JOIN mstpaymenttype e ON e.PaymentTypeId = a.PaymentTypeId 
                LEFT JOIN mstppntagihan f ON f.PpnId = a.PpnId 
                LEFT JOIN mstpphtagihan g ON g.PphId = a.PphId 
                LEFT JOIN users h on a.ReceivedId = h.id
                WHERE a.DeletedDate IS NULL AND a.LockDate is NOT NULL";

        $column_order = array( 
          'd.BillTypeCode',
          'a.BuktiNo',
          'a.InvoiceNo',
          'c.VendorName',
          'a.ReceivedDate',
          'h.name', 
          'a.BuktiNo',
        );
        
        $column_search = array(
          'd.BillTypeCode',
          'a.BuktiNo',
          'a.InvoiceNo',
          'c.VendorName',
          'a.ReceivedDate',
        ); 

        $order = array('a.BuktiNo' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $val->BillTypeCode.$val->BuktiNo;
            $row[] = $val->InvoiceNo;
            $row[] = $val->VendorName;
            $row[] = date("d F Y", strtotime($val->ReceivedDate));
            $row[] = $val->PendingBy;
            //$row[] = date("d F Y", strtotime($val->InvoiceDate));
            $row[] = '<a href="#" id="print" onclick="javascript:modalPrint(\''.$val->PenerimaanInvoiceId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak Status Check list"></i>
                      </a>
                      '.anchor(
                        site_url('PenerimaanInvoice/read/'.$val->PenerimaanInvoiceId),
                        '<i class="glyphicon glyphicon-eye-open"></i>',
                        array('title'=>'detail')
                      ).' '.
                     anchor(
                        site_url('PenerimaanInvoice/update/'.$val->PenerimaanInvoiceId),
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

    public function ListDataAccept(){
        $sql = "SELECT DISTINCT(a.PenerimaanInvoiceId), a.*, b.ProyekCode, b.ProyekName, c.VendorName, d.BillTypeCode, 
                       d.BillTypeName, e.PaymentTypeCode, e.PaymentTypeName, f.PpnName, f.PpnValue, g.PphName, g.PphValue 
                       ,(
                            SELECT GROUP_CONCAT(mstjabatan.JabatanCode SEPARATOR ', ')
                            FROM seqpenerimaaninvoicestatus
                            JOIN mstjabatan on seqpenerimaaninvoicestatus.JabatanId = mstjabatan.JabatanId
                            WHERE seqpenerimaaninvoicestatus.Status = 1
                            	AND seqpenerimaaninvoicestatus.PenerimaanInvoiceId =  a.PenerimaanInvoiceId
                            GROUP BY seqpenerimaaninvoicestatus.PenerimaanInvoiceId
                        ) ApproveBy, h.name AS ReceivedByName
                FROM  (
                        SELECT PenerimaanInvoiceId, count(PenerimaanInvoiceId)
                        FROM
                        (
                        	select distinct(PenerimaanInvoiceId) FROM seqpenerimaaninvoicestatus WHERE Status = 1
                        	UNION ALL select distinct(PenerimaanInvoiceId) FROM seqpenerimaaninvoicestatus WHERE Status = 2
                        ) temp
                        GROUP BY PenerimaanInvoiceId
                        HAVING count(PenerimaanInvoiceId) = 1
                        ) w  
                JOIN trnpenerimaaninvoice a ON w.PenerimaanInvoiceId=a.PenerimaanInvoiceId 
                LEFT JOIN trnproyek b ON b.ProyekId = a.ProyekId 
                LEFT JOIN mstvendor c ON c.VendorId = a.VendorId 
                LEFT JOIN mstbilltype d ON d.BillTypeId = a.BillTypeId 
                LEFT JOIN mstpaymenttype e ON e.PaymentTypeId = a.PaymentTypeId 
                LEFT JOIN mstppntagihan f ON f.PpnId = a.PpnId 
                LEFT JOIN mstpphtagihan g ON g.PphId = a.PphId 
                LEFT JOIN users h on a.ReceivedId = h.id
                WHERE a.DeletedDate IS NULL ";

        $column_order = array( 
          'd.BillTypeCode',
          'a.BuktiNo',
          'a.InvoiceNo',
          'c.VendorName',
          'a.ReceivedDate',
          'h.name', 
          'a.BuktiNo',
        );
        
        $column_search = array(
          'd.BillTypeCode',
          'a.BuktiNo',
          'a.InvoiceNo',
          'c.VendorName',
          'a.ReceivedDate',
        ); 

        $order = array('a.BuktiNo' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $val->BillTypeCode.$val->BuktiNo;
            $row[] = $val->InvoiceNo;
            $row[] = $val->VendorName;
            $row[] = date("d F Y", strtotime($val->ReceivedDate));
            $row[] = $val->ApproveBy;
            //$row[] = date("d F Y", strtotime($val->InvoiceDate));
            $row[] = '<a href="#" id="print" onclick="javascript:modalPrint(\''.$val->PenerimaanInvoiceId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak Status Check list"></i>
                      </a>
                      '.anchor(
                        site_url('PenerimaanInvoice/read/'.$val->PenerimaanInvoiceId),
                        '<i class="glyphicon glyphicon-eye-open"></i>',
                        array('title'=>'detail')
                      ).' '.
                     anchor(
                        site_url('PenerimaanInvoice/update/'.$val->PenerimaanInvoiceId),
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

    public function ListDataReject(){
        $sql = "SELECT DISTINCT(a.PenerimaanInvoiceId), a.*, b.ProyekCode, b.ProyekName, c.VendorName, d.BillTypeCode, 
                       d.BillTypeName, e.PaymentTypeCode, e.PaymentTypeName, f.PpnName, f.PpnValue, g.PphName, g.PphValue 
                       ,(
                            SELECT GROUP_CONCAT(mstjabatan.JabatanCode SEPARATOR ', ')
                            FROM seqpenerimaaninvoicestatus
                            JOIN mstjabatan on seqpenerimaaninvoicestatus.JabatanId = mstjabatan.JabatanId
                            WHERE seqpenerimaaninvoicestatus.Status = 2 
                            	AND seqpenerimaaninvoicestatus.PenerimaanInvoiceId =  a.PenerimaanInvoiceId
                            GROUP BY seqpenerimaaninvoicestatus.PenerimaanInvoiceId
                        ) RejectBy, h.name AS ReceivedByName
                FROM  (select distinct(PenerimaanInvoiceId) FROM seqpenerimaaninvoicestatus WHERE Status = 2) w  
                JOIN trnpenerimaaninvoice a ON w.PenerimaanInvoiceId=a.PenerimaanInvoiceId 
                LEFT JOIN trnproyek b ON b.ProyekId = a.ProyekId 
                LEFT JOIN mstvendor c ON c.VendorId = a.VendorId 
                LEFT JOIN mstbilltype d ON d.BillTypeId = a.BillTypeId 
                LEFT JOIN mstpaymenttype e ON e.PaymentTypeId = a.PaymentTypeId 
                LEFT JOIN mstppntagihan f ON f.PpnId = a.PpnId 
                LEFT JOIN mstpphtagihan g ON g.PphId = a.PphId 
                LEFT JOIN users h on a.ReceivedId = h.id
                WHERE a.DeletedDate IS NULL ";

        $column_order = array( 
          'd.BillTypeCode',
          'a.BuktiNo',
          'a.InvoiceNo',
          'c.VendorName',
          'a.ReceivedDate',
          'h.name', 
          'a.BuktiNo',
        );
        
        $column_search = array(
          'd.BillTypeCode',
          'a.BuktiNo',
          'a.InvoiceNo',
          'c.VendorName',
          'a.ReceivedDate',
        ); 

        $order = array('a.BuktiNo' => 'ASC');

        $list = $this->ListDataModel->get_datatables($sql, $column_search, $column_order, $order);
        $data = array();
        $no = 0;
        foreach ($list as $val) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $val->BillTypeCode.$val->BuktiNo;
            $row[] = $val->InvoiceNo;
            $row[] = $val->VendorName;
            $row[] = date("d F Y", strtotime($val->ReceivedDate));
            $row[] = $val->RejectBy;
            //$row[] = date("d F Y", strtotime($val->InvoiceDate));
            $row[] = '<a href="#" id="print" onclick="javascript:modalPrint(\''.$val->PenerimaanInvoiceId.'\');">
                        <i class="glyphicon glyphicon-print" title="Cetak Status Check list"></i>
                      </a>
                      '.anchor(
                        site_url('PenerimaanInvoice/read/'.$val->PenerimaanInvoiceId),
                        '<i class="glyphicon glyphicon-eye-open"></i>',
                        array('title'=>'detail')
                      ).' '.
                     anchor(
                        site_url('PenerimaanInvoice/update/'.$val->PenerimaanInvoiceId),
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

    function UploadDocumentLampiran($id = NULL){

      $dir_doc = './upload/lampiran/';
      // $dir_doc = $_SERVER['DOCUMENT_ROOT'].'/upload/lampiran/';
      $attr = ($_FILES['SppUpload']['name']) ? "SspUpload" : "BuktiPotongUpload";
      $name = ($_FILES['SppUpload']['name']) ? "Ssp" : "Bukti Potong";

      $filename = $_FILES[$attr]['name'];
      // var_dump($filename);exit();
      $ext = pathinfo( $filename, PATHINFO_EXTENSION );
      $ekstensi = array('pdf'); // Ektensi yg diterima

      $html = "";

      //filter ektensi gambar yang diterima
      if( in_array($ext, $ekstensi ))
      {
        //maks ukuran gambar 500kb
        if($_FILES[$attr]['size'] < 5000000)
        {
          $filename = $name.$id.".".$ext;
          if (move_uploaded_file( $_FILES[$attr]['tmp_name'], $dir_doc . $filename ))
          {
            $data = array(
              'PenerimaanInvoiceId' => $id,
              'Name' => $name,
              'Path' => $filename,
              'UploadDate' => date("Y-m-d H:i:s"),
              'UploadByUserId' => $this->session->userdata('user_id'),
            );
            $this->PenerimaanInvoice_model->deleteLampiran($filename);
            $this->PenerimaanInvoice_model->insertLampiran($data);
            $html = "Upload ".$name." sukses";
          }
          else $html = "Upload ".$name." gagal";
        }
        else $html = "Ukuran file terlalu besar";
      }
      else $html = "Format file tidak diizinkan";

      echo  $html;
    }

    function GetLampiran(){
      $PenerimaanInvoiceId = $this->input->post('PenerimaanInvoiceId', TRUE);
      $data = $this->PenerimaanInvoice_model->getLampiran($PenerimaanInvoiceId);
      echo json_encode($data);
    }
    
    function Ttd(){
        $PenerimaanInvoiceId = $this->input->post('PenerimaanInvoiceId', TRUE);
        $Ttd = $this->input->post('Ttd');
        $JabatanId = $this->input->post('JabatanId', TRUE);
        $Status = $this->input->post('Status', TRUE);
        $Note = $this->input->post('Note', TRUE);
        $data = array(
          //'PenerimaanInvoiceId' => $PenerimaanInvoiceId,
          'JabatanId' => $this->session->userdata('jabatanid'),
          'Status' => $Status,
          'Note' => $Note,
          'StatusDate' => date("Y-m-d H:i:s"),
          'StatusByUserId' => $this->session->userdata('user_id'),
          'Ttd' => $Ttd,
        );
          
        $res = $this->PenerimaanInvoice_model->InvoiceVerification($PenerimaanInvoiceId, $this->session->userdata('jabatanid'), $data);
        
        $TotStatus = $this->PenerimaanInvoice_model->cekCompletedStatusInvoice($PenerimaanInvoiceId);
        if ($TotStatus->TotStatus > 0)
        {
            $data['PenerimaanInvoiceId']  = $PenerimaanInvoiceId;
            $subject = "Pemberitahuan Invoice Baru";
            $this->send_email($data, $subject);
        }
        //if($res) echo 'Verifikasi sukses'; else echo 'Verifikasi gagal';
        $this->session->set_flashdata('message', 'Verifikasi Berhasil');
        
    }

  function LockPenerimaanInvoice(){
    $arrAccessMenu = $this->session->userdata('access_menu');
    if(!$arrAccessMenu[8]['Update']){
      $this->session->set_flashdata('message', 'Anda tidak punya akses');
    } else {
      $PenerimaanInvoiceId = $this->input->post('PenerimaanInvoiceId', TRUE);
      $data = array(
        'LockDate' => date("Y-m-d H:i:s"),
        'LockByUserId' => $this->session->userdata('user_id')
      );
      
      $isNew = 1;
      $DataInvoiceNewStatus = $this->PenerimaanInvoice_model->cekNewInvoice($PenerimaanInvoiceId);
      if ($DataInvoiceNewStatus->Status != 0) $isNew = 0;
      
      $res = $this->PenerimaanInvoice_model->setPendingInvoiceStatus($PenerimaanInvoiceId);
      
      $res = $this->PenerimaanInvoice_model->update($PenerimaanInvoiceId, $data);
        
      // send email
      $data['PenerimaanInvoiceId']  = $PenerimaanInvoiceId;
      $subject = ($isNew == 1) ? "Pemberitahuan Invoice Baru" : "Pemberitahuan Revisi Invoice"; 
     $this->send_email($data, $subject);
      //if($res){
        $this->session->set_flashdata('message', 'Data dikunci');
      //}else{
        //$this->session->set_flashdata('message', 'Proses gagal');
      //}
    }
  }

}

/* End of file PenerimaanInvoice.php */
/* Location: ./application/controllers/PenerimaanInvoice.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-13 13:43:46 */
/* http://harviacode.com */
