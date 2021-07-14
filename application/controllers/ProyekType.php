<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ProyekType extends Parent_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('ProyekType_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/proyekTypeList'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $Datas['ArrData'] = $this->ProyekType_model->get_all(); // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah

      $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function read($id)
    {
      $this->Content = 'content/proyekTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $row = $this->ProyekType_model->get_by_id($id);
      if ($row) {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('ProyekType/create_action'),
              'ProyekTypeId' => $row->ProyekTypeId,
          		'ProyekTypeCode' => $row->ProyekTypeCode,
          		'ProyektypeName' => $row->ProyektypeName,
              'NoUrutMin' => $row->NoUrutMin,
              'NoUrutMax' => $row->NoUrutMax,
          		'CreatedDate' => $row->CreatedDate,
          		'CreatedByUserId' => $row->CreatedByUserId,
          		'LastChangedDate' => $row->LastChangedDate,
          		'LastChangedByUserId' => $row->LastChangedByUserId,
          		'DeletedDate' => $row->DeletedDate,
          		'DeletedUserId' => $row->DeletedUserId,
          );
          $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('ProyekType'));
      }

    }

    public function create()
    {
      $this->Content = 'content/proyekTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $Datas['ArrData'] = array(
        'button' => 'Simpan',
        'action' => site_url('proyekType/create_action'),
        'ProyekTypeId' => set_value('ProyekTypeId'),
        'ProyekTypeCode' => set_value('ProyekTypeCode'),
        'ProyektypeName' => set_value('ProyektypeName'),
        'NoUrutMin' => set_value('NoUrutMin'),
        'NoUrutMax' => set_value('NoUrutMax'),
        'CreatedByUserId' => $this->session->userdata('userid'),
        'CreatedDate' => date('Y-m-d H:i:s'),
        'LastChangedDate' => '',
        'LastChangedByUserId' => '',
        'DeletedUserId' => '',
        'DeletedDate' => '',
      );
      $this->Layouts($Datas); // Layouts adalah template dashboard admin

    }

    public function create_action()
    {
      $this->_rules();

      if ($this->form_validation->run() == FALSE) {
          $this->create();
      } else {
          $data = array(
                    'ProyekTypeCode' => $this->input->post('ProyekTypeCode',TRUE),
                    'ProyektypeName' => $this->input->post('ProyektypeName',TRUE),
                    'NoUrutMin' => $this->input->post('NoUrutMin',TRUE),
                    'NoUrutMax' => $this->input->post('NoUrutMax',TRUE),
                    'ProyektypeName' => $this->input->post('ProyektypeName',TRUE),
                    'CreatedDate' => date("Y-m-d H:i:s"),
                    'CreatedByUserId' => $this->session->userdata('userid')
                  );

          $this->ProyekType_model->insert($data);
          $this->session->set_flashdata('message', 'Data disimpan');
          redirect(site_url('ProyekType'));
      }

    }

    public function update($id)
    {
      $this->Content = 'content/proyekTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $row = $this->ProyekType_model->get_by_id($id);

      if ($row) {
        $Datas['ArrData'] = array(
                              'button' => 'Perbarui',
                              'action' => site_url('proyekType/update_action/'.$id),
                          		'ProyekTypeId' => set_value('ProyekTypeId', $row->ProyekTypeId),
                          		'ProyekTypeCode' => set_value('ProyekTypeCode', $row->ProyekTypeCode),
                          		'ProyektypeName' => set_value('ProyektypeName', $row->ProyektypeName),
                              'NoUrutMin' => set_value('NoUrutMin', $row->NoUrutMin),
                              'NoUrutMax' => set_value('NoUrutMax', $row->NoUrutMax),
                              'CreatedByUserId' => $row->CreatedByUserId,
                              'CreatedDate' => $row->CreatedDate,
                              'LastChangedDate' => $row->LastChangedDate,
                              'LastChangedByUserId' => $row->LastChangedByUserId,
                              'DeletedUserId' => $row->DeletedUserId,
                              'DeletedDate' => $row->DeletedDate,
                            );
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('ProyekType'));
      }

    }

    public function update_action($id)
    {
      $this->_rules();

      if ($this->form_validation->run() == FALSE) {
          $this->update($id);
      } else {
          $data = array(
                    'ProyekTypeCode' => $this->input->post('ProyekTypeCode',TRUE),
                    'ProyektypeName' => $this->input->post('ProyektypeName',TRUE),
                    'NoUrutMin' => $this->input->post('NoUrutMin',TRUE),
                    'NoUrutMax' => $this->input->post('NoUrutMax',TRUE),
                    'LastChangedDate' => date("Y-m-d H:i:s"),
                    'LastChangedByUserId' => $this->session->userdata('userid'),
                  );

          $this->ProyekType_model->update($id, $data);
          $this->session->set_flashdata('message', 'Data diperbarui');
          redirect(site_url('ProyekType'));
      }

    }

    public function delete($id)
    {
      $row = $this->ProyekType_model->get_by_id($id);

      if ($row) {
        $data = array(
                  'DeletedDate' => date("Y-m-d H:i:s"),
                  'DeletedUserId' => $this->session->userdata('userid')
                );

        $this->ProyekType_model->update($row->ProyekTypeId, $data);

        $this->session->set_flashdata('message', 'Data telah dihapus');
        redirect(site_url('ProyekType'));
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('ProyekType'));
      }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('ProyekTypeCode', 'proyektypecode', 'trim|required');
      	$this->form_validation->set_rules('ProyektypeName', 'proyektypename', 'trim|required');
        $this->form_validation->set_rules('NoUrutMin', 'nourutmin', 'trim|required');
        $this->form_validation->set_rules('NoUrutMax', 'nourutmax', 'trim|required');

      	$this->form_validation->set_rules('ProyekTypeId', 'ProyekTypeId', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file ProyekType.php */
/* Location: ./application/controllers/ProyekType.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 11:25:49 */
/* http://harviacode.com */
