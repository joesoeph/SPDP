<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sender extends Parent_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Sender_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/SenderList'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[26]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->Sender_model->get_all(); // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah
      }

      $this->Layouts($Datas); // Layouts adalah template dashboard admin$sender = $this->Sender_model->get_all();

    }

    public function read($id)
    {
      $this->Content = 'content/SenderForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $row = $this->Sender_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[26]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
         $Datas['ArrData'] = array(
            'button' => '',
            'action' => site_url('Sender/create_action'),
            'SenderId' => $row->SenderId,
        		'SenderName' => $row->SenderName,
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
        redirect(site_url('Sender'));
      }
    }

    public function create()
    {
      $this->Content = 'content/SenderForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[26]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
          'button' => 'Simpan',
          'action' => site_url('sender/create_action'),
          'SenderId' => set_value('SenderId'),
          'SenderName' => set_value('SenderName'),
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
      if($arrAccessMenu[26]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                      'SenderName' => $this->input->post('SenderName',TRUE),
                      'CreatedDate' => date("Y-m-d H:i:s"),
                      'CreatedByUserId' => $this->session->userdata('user_id')
                    );

            $this->Sender_model->insert($data);
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('Sender'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Sender'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/SenderForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $row = $this->Sender_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[26]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('sender/update_action/'.$id),
        		'SenderId' => set_value('SenderId', $row->SenderId),
        		'SenderName' => set_value('SenderName', $row->SenderName),
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
        redirect(site_url('Sender'));
      }

    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[26]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
                      'SenderName' => $this->input->post('SenderName',TRUE),
                      'LastChangedDate' => date("Y-m-d H:i:s"),
                      'LastChangedByUserId' => $this->session->userdata('user_id'),
                    );

            $this->Sender_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('Sender'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Sender'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[26]['Delete']){
        $row = $this->Sender_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date("Y-m-d H:i:s"),
                    'DeletedUserId' => $this->session->userdata('user_id')
                  );

          $this->Sender_model->update($row->SenderId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Sender'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Sender'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Sender'));
      }
    }

    public function _rules()
    {
    	$this->form_validation->set_rules('SenderName', 'sendername', 'trim|required');

    	$this->form_validation->set_rules('SenderId', 'SenderId', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Sender.php */
/* Location: ./application/controllers/Sender.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 14:52:56 */
/* http://harviacode.com */
