<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BillType extends Parent_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('BillType_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/billTypeList'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[14]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->BillType_model->get_all(); // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah
      }

      $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function read($id)
    {
      $this->Content = 'content/billTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $row = $this->BillType_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[14]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('BillType/create_action'),
              'BillTypeId' => $row->BillTypeId,
          		'BillTypeCode' => $row->BillTypeCode,
          		'BillTypeName' => $row->BillTypeName,
              'NoUrutMin' => $row->NoUrutMin,
              'NoUrutMax' => $row->NoUrutMax,
          		'CreatedDate' => $row->CreatedDate,
          		'CreatedByUserId' => $row->CreatedByUserId,
          		'LastChangedDate' => $row->LastChangedDate,
          		'LastChangedByUserId' => $row->LastChangedByUserId,
          		'DeletedDate' => $row->DeletedDate,
          		'DeletedUserId' => $row->DeletedUserId,
          );
         }
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('BillType'));
      }

    }

    public function create()
    {
      $this->Content = 'content/billTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[14]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
          'button' => 'Simpan',
          'action' => site_url('billType/create_action'),
          'BillTypeId' => set_value('BillTypeId'),
          'BillTypeCode' => set_value('BillTypeCode'),
          'BillTypeName' => set_value('BillTypeName'),
          'NoUrutMin' => set_value('NoUrutMin'),
          'NoUrutMax' => set_value('NoUrutMax'),
          'CreatedByUserId' => $this->session->userdata('user_id'),
          'CreatedDate' => date('Y-m-d H:i:s'),
          'LastChangedDate' => '',
          'LastChangedByUserId' => '',
          'DeletedUserId' => '',
          'DeletedDate' => '',
        );
      }
      $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[14]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                      'BillTypeCode' => $this->input->post('BillTypeCode',TRUE),
                      'BillTypeName' => $this->input->post('BillTypeName',TRUE),
                      'NoUrutMin' => $this->input->post('NoUrutMin',TRUE),
                      'NoUrutMax' => $this->input->post('NoUrutMax',TRUE),
                      'BillTypeName' => $this->input->post('BillTypeName',TRUE),
                      'CreatedDate' => date("Y-m-d H:i:s"),
                      'CreatedByUserId' => $this->session->userdata('user_id')
                    );

            $this->BillType_model->insert($data);
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('BillType'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('BillType'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/billTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $row = $this->BillType_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[14]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('billType/update_action/'.$id),
        		'BillTypeId' => set_value('BillTypeId', $row->BillTypeId),
        		'BillTypeCode' => set_value('BillTypeCode', $row->BillTypeCode),
        		'BillTypeName' => set_value('BillTypeName', $row->BillTypeName),
            'NoUrutMin' => set_value('NoUrutMin', $row->NoUrutMin),
            'NoUrutMax' => set_value('NoUrutMax', $row->NoUrutMax),
            'CreatedByUserId' => $row->CreatedByUserId,
            'CreatedDate' => $row->CreatedDate,
            'LastChangedDate' => $row->LastChangedDate,
            'LastChangedByUserId' => $row->LastChangedByUserId,
            'DeletedUserId' => $row->DeletedUserId,
            'DeletedDate' => $row->DeletedDate,
          );
        }
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('BillType'));
      }

    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[14]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
                      'BillTypeCode' => $this->input->post('BillTypeCode',TRUE),
                      'BillTypeName' => $this->input->post('BillTypeName',TRUE),
                      'NoUrutMin' => $this->input->post('NoUrutMin',TRUE),
                      'NoUrutMax' => $this->input->post('NoUrutMax',TRUE),
                      'LastChangedDate' => date("Y-m-d H:i:s"),
                      'LastChangedByUserId' => $this->session->userdata('user_id'),
                    );

            $this->BillType_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('BillType'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('BillType'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[14]['Delete']){
        $row = $this->BillType_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date("Y-m-d H:i:s"),
                    'DeletedUserId' => $this->session->userdata('user_id')
                  );

          $this->BillType_model->update($row->BillTypeId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('BillType'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('BillType'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('BillType'));
      }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('BillTypeCode', 'billtypecode', 'trim|required');
      	$this->form_validation->set_rules('BillTypeName', 'billtypename', 'trim|required');
        $this->form_validation->set_rules('NoUrutMin', 'nourutmin', 'trim|required');
        $this->form_validation->set_rules('NoUrutMax', 'nourutmax', 'trim|required');

      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file BillType.php */
/* Location: ./application/controllers/BillType.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 11:25:49 */
/* http://harviacode.com */
