<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jabatan extends Parent_Controller
{

		protected $arrAccessMenu;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Jabatan_model');
        $this->load->library('form_validation');
				$this->arrAccessMenu = $this->session->userdata('access_menu')[3];
    }

    public function index()
    {
      $this->Content = 'content/jabatanList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      if(!$this->arrAccessMenu['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->Jabatan_model->get_all();
      }

      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/jabatanForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->Jabatan_model->get_by_id($id);
      if ($row) {
        if(!$this->arrAccessMenu['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('jabatan/create_action'),
          		'JabatanId' => $row->JabatanId,
          		'JabatanCode' => $row->JabatanCode,
          		'JabatanName' => $row->JabatanName,
          		'Description' => $row->Description,
          		'CreatedDate' => $row->CreatedDate,
          		'CreatedByUserId' => $row->CreatedByUserId,
          		'LastChangedDate' => $row->LastChangedDate,
          		'LastChangedByUserId' => $row->LastChangedByUserId,
          		'DeletedDate' => $row->DeletedDate,
          		'DeletedUserId' => $row->DeletedUserId,
          	);
        }
        $this->Layouts($Datas);
      } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('jabatan'));
      }
    }

    public function create()
    {
      $this->Content = 'content/jabatanForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      if(!$this->arrAccessMenu['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('jabatan/create_action'),
      	    'JabatanId' => set_value('JabatanId'),
      	    'JabatanCode' => set_value('JabatanCode'),
      	    'JabatanName' => set_value('JabatanName'),
      	    'Description' => set_value('Description'),
      	    'CreatedDate' => set_value('CreatedDate'),
      	    'CreatedByUserId' => set_value('CreatedByUserId'),
      	    'LastChangedDate' => set_value('LastChangedDate'),
      	    'LastChangedByUserId' => set_value('LastChangedByUserId'),
      	    'DeletedDate' => set_value('DeletedDate'),
      	    'DeletedUserId' => set_value('DeletedUserId'),
      	);
      }
      $this->Layouts($Datas);
    }

    public function create_action()
    {
      if($this->arrAccessMenu['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
          $data = array(
        		'JabatanCode' => $this->input->post('JabatanCode',TRUE),
        		'JabatanName' => $this->input->post('JabatanName',TRUE),
        		'Description' => $this->input->post('Description',TRUE),
            'CreatedDate' => date("Y-m-d H:i:s"),
            'CreatedByUserId' => $this->session->userdata('user_id')
          );

            $this->Jabatan_model->insert($data);
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('jabatan'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Jabatan'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/jabatanForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->Jabatan_model->get_by_id($id);

      if ($row) {
        if(!$this->arrAccessMenu['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('jabatan/update_action/'.$id),
            'JabatanId' => set_value('JabatanId', $row->JabatanId),
            'JabatanCode' => set_value('JabatanCode', $row->JabatanCode),
            'JabatanName' => set_value('JabatanName', $row->JabatanName),
            'Description' => set_value('Description', $row->Description),
            'CreatedDate' => set_value('CreatedDate', $row->CreatedDate),
            'CreatedByUserId' => set_value('CreatedByUserId', $row->CreatedByUserId),
            'LastChangedDate' => set_value('LastChangedDate', $row->LastChangedDate),
            'LastChangedByUserId' => set_value('LastChangedByUserId', $row->LastChangedByUserId),
            'DeletedDate' => set_value('DeletedDate', $row->DeletedDate),
            'DeletedUserId' => set_value('DeletedUserId', $row->DeletedUserId),
          );
        }
        $this->Layouts($Datas);
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('jabatan'));
      }

    }

    public function update_action($id)
    {
      if($this->arrAccessMenu['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('JabatanId', TRUE));
        } else {
            $data = array(
          		'JabatanCode' => $this->input->post('JabatanCode',TRUE),
          		'JabatanName' => $this->input->post('JabatanName',TRUE),
          		'Description' => $this->input->post('Description',TRUE),
          		'LastChangedDate' => date("Y-m-d H:i:s"),
              'LastChangedByUserId' => $this->session->userdata('user_id')
          	);

            $this->Jabatan_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('jabatan'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Jabatan'));
      }
    }

    public function delete($id)
    {
      if($this->arrAccessMenu['Delete']){
        $row = $this->Jabatan_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date('Y-m-d H:i:s'),
                    'DeletedUserId' => $this->session->userdata('userid')
                  );

          $this->Jabatan_model->update($row->JabatanId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('jabatan'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('jabatan'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Jabatan'));
      }
    }

    public function _rules()
    {
    	$this->form_validation->set_rules('JabatanCode', 'jabatancode', 'trim|required');
    	$this->form_validation->set_rules('JabatanName', 'jabatanname', 'trim|required');

    	$this->form_validation->set_rules('JabatanId', 'JabatanId', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Jabatan.php */
/* Location: ./application/controllers/Jabatan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-04-01 23:21:19 */
/* http://harviacode.com */
