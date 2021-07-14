<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Setting_model', 'Document_model', 'Proyek_model'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/proyekList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $Datas['ArrData'] = $this->Proyek_model->get_all();

      $this->Layouts($Datas);
    }

    public function BillDocument(){
      $this->Content = 'content/billDocumentForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-duallistbox/bootstrap-duallistbox.css',
      ];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js'
      ];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[23]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['DataBillType'] = $this->Setting_model->billType();
        $Datas['DataDocument'] = $this->Document_model->get_all();
        
        foreach ($Datas['DataBillType'] as $val) {
          $DataBillDocument[$val->BillTypeId] = $this->Setting_model->billDocument($val->BillTypeId);
        }

        $Datas['DataBillDocument'] = $DataBillDocument;
      }
      $this->Layouts($Datas);

    }

    public function updateBillDocument(){
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[23]['Update']){
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Setting/BillDocument'));
      } else {
        $DataBillType = $this->Setting_model->billType();
        $this->Setting_model->deleteBillDocument();

        foreach ($DataBillType as $val) {
          $BillType = explode(",",$this->input->post('BillType'.$val->BillTypeId));
          foreach ($BillType as $DocumentId) {
            $data = array(
              'BillTypeId' => $val->BillTypeId,
              'DocumentId' => $DocumentId
            );
            $this->Setting_model->insertBillDocument($data);
          };
        }
        $this->session->set_flashdata('message', 'Perubahan disimpan');
        redirect(site_url('Setting/BillDocument'));
      }
    }

    public function Verifycator(){
      $this->Content = 'content/verifycatorForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-duallistbox/bootstrap-duallistbox.css',
      ];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js'
      ];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[5]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $DataProyek = $this->Proyek_model->get_all();
        foreach ($DataProyek as $val) {
          $Datas['DataVerifycator'][$val->ProyekId] = $this->Setting_model->verifycator($val->ProyekId);
        }
        $Datas['DataProyek'] = $DataProyek;
      }
      $this->Layouts($Datas);

    }

    public function updateVerifycator(){
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[5]['Update']){
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Setting/Verifycator'));
      } else {
        for ($i=1; $i <= $this->input->post('TotalProyek'); $i++) { 
          $this->Setting_model->deleteVerifycator($this->input->post('ProyekId'.$i));
          $Verify = explode(",",$this->input->post('Verify'.$i));
          foreach ($Verify as $val) {
            $d = array(
              'JabatanId' => $val,
              'ProyekId'  => $this->input->post('ProyekId'.$i)
            );
            $this->Setting_model->insertVerifycator($d);
          };
        }
        $this->session->set_flashdata('message', 'Perubahan disimpan');
        redirect(site_url('Setting/Verifycator'));
      }
    }

    public function VerifycatorAgreement(){
      $this->Content = 'content/verifycatorAgreementForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-duallistbox/bootstrap-duallistbox.css',
      ];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js'
      ];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[32]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $ArrData = ['SPP', 'PO', 'BTL', 'SPK'];
        foreach ($ArrData as $val) {
          $Datas['DataVerifycator'][$val] = $this->Setting_model->verifycatorAgreement($val);
        }

        $Datas['DataAgreement'] = $ArrData;
      }
      $this->Layouts($Datas);

    }

    public function updateVerifycatorAgreement(){
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[32]['Update']){
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Setting/VerifycatorAgreement'));
      } else {
        for ($i=1; $i <= $this->input->post('TotalAgreement'); $i++) { 
          $this->Setting_model->deleteVerifycatorAgreement($this->input->post('Agreement'.$i));
          $Verify = explode(",",$this->input->post('Verify'.$i));
          if($this->input->post('Verify'.$i)){
            foreach ($Verify as $val) {
              $d = array(
                'JabatanId' => $val,
                'Agreement'  => $this->input->post('Agreement'.$i)
              );
              $this->Setting_model->insertVerifycatorAgreement($d);
            };
          }
        }
        $this->session->set_flashdata('message', 'Perubahan disimpan');
        redirect(site_url('Setting/VerifycatorAgreement'));
      }
    }
}

/* End of file Setting.php */
/* Location: ./application/controllers/Setting.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-13 09:33:16 */
/* http://harviacode.com */
