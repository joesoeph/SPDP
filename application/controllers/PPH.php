<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PPH extends Parent_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('PPH_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/pphList'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[18]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->PPH_model->get_all(); // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah
      }
      $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function read($id)
    {
      $this->Content = 'content/pphForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $row = $this->PPH_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[18]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('PPH/create_action'),
              'PphId' => $row->PphId,
          		'PphName' => $row->PphName,
          		'PphValue' => $row->PphValue,
          );
        }
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('PPH'));
      }
    }

    public function create()
    {
      $this->Content = 'content/pphForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[18]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
          'button' => 'Simpan',
          'action' => site_url('PPH/create_action'),
          'PphId' => set_value('PphId'),
    	    'PphName' => set_value('PphName'),
    	    'PphValue' => set_value('PphValue'),
        );
      }
      $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[18]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                      'PphName' => $this->input->post('PphName',TRUE),
                      'PphValue' => $this->input->post('PphValue',TRUE),
                    );

            $this->PPH_model->insert($data);
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('PPH'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PPH'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/pphForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $row = $this->PPH_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[18]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
                              'button' => 'Perbarui',
                              'action' => site_url('PPH/update_action/'.$id),
                          		'PphId' => set_value('PphId', $row->PphId),
                          		'PphName' => set_value('PphName', $row->PphName),
                          		'PphValue' => set_value('PphValue', $row->PphValue),
                            );
        }
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('PPH'));
      }
    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[18]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
                      'PphName' => $this->input->post('PphName',TRUE),
                      'PphValue' => $this->input->post('PphValue',TRUE),
                    );

            $this->PPH_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('PPH'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PPH'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[18]['Delete']){
        $row = $this->PPH_model->get_by_id($id);

        if ($row) {
            $this->PPH_model->delete($id);
            $this->session->set_flashdata('message', 'Data telah dihapus');
            redirect(site_url('PPH'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('PPH'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PPH'));
      }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('PphName', 'pphname', 'trim|required');
	$this->form_validation->set_rules('PphValue', 'pphvalue', 'trim|required');

	$this->form_validation->set_rules('PphId', 'PphId', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file PPH.php */
/* Location: ./application/controllers/PPH.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 16:38:30 */
/* http://harviacode.com */
