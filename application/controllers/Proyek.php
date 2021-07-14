<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proyek extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Proyek_model', 'Vendor_model'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/proyekList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[12]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->Proyek_model->get_all();
      }

      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/proyekForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-duallistbox/bootstrap-duallistbox.css',
      ];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js'
      ];
      $Datas['AddJsFooter'] = [];

      $row = $this->Proyek_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[12]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('proyek/create_action'),
          		'ProyekId' => $row->ProyekId,
          		'BillTypeId' => $row->BillTypeId,
          		'ProyekCode' => $row->ProyekCode,
          		'ProyekName' => $row->ProyekName,
          		'ProyekDescription' => $row->ProyekDescription,
          		'CreatedDate' => $row->CreatedDate,
          		'CreatedByUserId' => $row->CreatedByUserId,
          		'LastChangedDate' => $row->LastChangedDate,
          		'LastChangedByUserId' => $row->LastChangedByUserId,
          		'DeletedDate' => $row->DeletedDate,
          		'DeletedUserId' => $row->DeletedUserId,
	        );

          $Datas['DataVendor'] = $this->Proyek_model->viewProyek($id);
        }

        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Proyek'));
      }
    }

    public function create()
    {
      $this->Content = 'content/proyekForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-duallistbox/bootstrap-duallistbox.css',
      ];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js'
      ];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[12]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('proyek/create_action'),
      	    'ProyekId' => set_value('ProyekId'),
      	    'BillTypeId' => set_value('BillTypeId'),
      	    'ProyekCode' => set_value('ProyekCode'),
      	    'ProyekName' => set_value('ProyekName'),
      	    'ProyekDescription' => set_value('ProyekDescription'),
            'CreatedByUserId' => $this->session->userdata('user_id'),
            'CreatedDate' => date('Y-m-d H:i:s'),
            'LastChangedDate' => '',
            'LastChangedByUserId' => '',
            'DeletedUserId' => '',
            'DeletedDate' => '',
      	);

        $Datas['DataVendor'] = $this->Vendor_model->get_all();
      }
      $this->Layouts($Datas);
    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[12]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
          $ProyekId = uniqid();
          $ProyekId.= uniqid();
          $data = array(
              'ProyekId' => $ProyekId,
          		'BillTypeId' => $this->input->post('BillTypeId',TRUE),
          		'ProyekCode' => $this->input->post('ProyekCode',TRUE),
          		'ProyekName' => $this->input->post('ProyekName',TRUE),
          		'ProyekDescription' => $this->input->post('ProyekDescription',TRUE),
              'CreatedDate' => date("Y-m-d H:i:s"),
              'CreatedByUserId' => $this->session->userdata('user_id')
            );

            $this->Proyek_model->insert($data);

            $ProyekSeqId = explode(",",$_POST['ProyekSeqId']);
            foreach ($ProyekSeqId as $val) {
              $d = array(
            		'ProyekId' => $ProyekId,
            		'VendorId' => $val
            	);
              $this->Proyek_model->insertSeqProyek($d);
            };

            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('Proyek'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Proyek'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/proyekForm';
      $Datas['AddCss'] = [
        'assets/vendor/bootstrap-duallistbox/bootstrap-duallistbox.css',
      ];
      $Datas['AddJsHeader'] = [
        'assets/vendor/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js'
      ];
      $Datas['AddJsFooter'] = [];

      $row = $this->Proyek_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[12]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('proyek/update_action/'.$id),
        		'ProyekId' => set_value('ProyekId', $row->ProyekId),
        		'BillTypeId' => set_value('BillTypeId', $row->BillTypeId),
        		'ProyekCode' => set_value('ProyekCode', $row->ProyekCode),
        		'ProyekName' => set_value('ProyekName', $row->ProyekName),
        		'ProyekDescription' => set_value('ProyekDescription', $row->ProyekDescription),
            'CreatedByUserId' => $row->CreatedByUserId,
            'CreatedDate' => $row->CreatedDate,
            'LastChangedDate' => $row->LastChangedDate,
            'LastChangedByUserId' => $row->LastChangedByUserId,
            'DeletedUserId' => $row->DeletedUserId,
            'DeletedDate' => $row->DeletedDate,
  	      );

          $Datas['DataVendor'] = $this->Proyek_model->viewProyek($id);
        }
        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('Proyek'));
      }

    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[12]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
            		'BillTypeId' => $this->input->post('BillTypeId',TRUE),
            		'ProyekCode' => $this->input->post('ProyekCode',TRUE),
            		'ProyekName' => $this->input->post('ProyekName',TRUE),
            		'ProyekDescription' => $this->input->post('ProyekDescription',TRUE),
                'LastChangedDate' => date("Y-m-d H:i:s"),
                'LastChangedByUserId' => $this->session->userdata('user_id')
	          );

            $this->Proyek_model->update($id, $data);

            $this->Proyek_model->deleteSeqProyek($id);
            $ProyekSeqId = explode(",",$_POST['ProyekSeqId']);
            foreach ($ProyekSeqId as $val) {
              $d = array(
            		'ProyekId' => $id,
            		'VendorId' => $val
            	);
              $this->Proyek_model->insertSeqProyek($d);
            };

            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('Proyek'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Proyek'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[12]['Delete']){
        $row = $this->Proyek_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date("Y-m-d H:i:s"),
                    'DeletedUserId' => $this->session->userdata('user_id')
                  );

          $this->Proyek_model->update($row->ProyekId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Proyek'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Proyek'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Proyek'));
      }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('ProyekCode', 'proyekcode', 'trim|required');
      	$this->form_validation->set_rules('ProyekName', 'proyekname', 'trim|required');
      	$this->form_validation->set_rules('ProyekDescription', 'proyekdescription', 'trim|required');

      	$this->form_validation->set_rules('ProyekId', 'ProyekId', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Proyek.php */
/* Location: ./application/controllers/Proyek.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-13 09:33:16 */
/* http://harviacode.com */
