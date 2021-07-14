<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PPN extends Parent_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('PPN_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/ppnList'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[19]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->PPN_model->get_all(); // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah
      }
      $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function read($id)
    {
      $this->Content = 'content/ppnForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $row = $this->PPN_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[19]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('PPN/create_action'),
              'PpnId' => $row->PpnId,
          		'PpnName' => $row->PpnName,
          		'PpnValue' => $row->PpnValue,
          );
         }
          $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('ppn'));
      }
    }

    public function create()
    {
      $this->Content = 'content/ppnForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[19]['Write']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
      $Datas['ArrData'] = array(
        'button' => 'Simpan',
        'action' => site_url('PPN/create_action'),
        'PpnId' => set_value('PpnId'),
  	    'PpnName' => set_value('PpnName'),
  	    'PpnValue' => set_value('PpnValue'),
      );
    }
      $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[19]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                      'PpnName' => $this->input->post('PpnName',TRUE),
                      'PpnValue' => $this->input->post('PpnValue',TRUE),
                    );

            $this->PPN_model->insert($data);
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('PPN'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PPN'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/ppnForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $row = $this->PPN_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[19]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
                                'button' => 'Perbarui',
                                'action' => site_url('PPN/update_action/'.$id),
                            		'PpnId' => set_value('PpnId', $row->PpnId),
                            		'PpnName' => set_value('PpnName', $row->PpnName),
                            		'PpnValue' => set_value('PpnValue', $row->PpnValue),
                              );
        }
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('PPN'));
      }
    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[19]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
                      'PpnName' => $this->input->post('PpnName',TRUE),
                      'PpnValue' => $this->input->post('PpnValue',TRUE),
                    );

            $this->PPN_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('PPN'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PPN'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[19]['Delete']){
        $row = $this->PPN_model->get_by_id($id);

        if ($row) {
            $this->PPN_model->delete($id);
            $this->session->set_flashdata('message', 'Data telah dihapus');
            redirect(site_url('PPN'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('PPN'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PPN'));
      }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('PpnName', 'ppnname', 'trim|required');
	$this->form_validation->set_rules('PpnValue', 'ppnvalue', 'trim|required');

	$this->form_validation->set_rules('PpnId', 'PpnId', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file PPN.php */
/* Location: ./application/controllers/PPN.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 16:38:30 */
/* http://harviacode.com */
