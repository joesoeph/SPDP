<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Document extends Parent_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Document_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/documentList';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[20]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->Document_model->get_all();
      }
      $this->Layouts($Datas);
    }

    public function read($id)
    {
      $this->Content = 'content/documentForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->Document_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[20]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('document/create_action'),
          		'DocumentId' => $row->DocumentId,
          		'DocumentCode' => $row->DocumentCode,
          		'DocumentName' => $row->DocumentName,
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
          redirect(site_url('document'));
      }
    }

    public function create()
    {
      $this->Content = 'content/documentForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[20]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('document/create_action'),
      	    'DocumentId' => set_value('DocumentId'),
      	    'DocumentCode' => set_value('DocumentCode'),
      	    'DocumentName' => set_value('DocumentName'),
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
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[20]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
          $data = array(
        		'DocumentCode' => $this->input->post('DocumentCode',TRUE),
        		'DocumentName' => $this->input->post('DocumentName',TRUE),
        		'Description' => $this->input->post('Description',TRUE),
            'CreatedDate' => date("Y-m-d H:i:s"),
            'CreatedByUserId' => $this->session->userdata('user_id')
        	);

            $this->Document_model->insert($data);
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('document'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Document'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/documentForm';
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $row = $this->Document_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[20]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
            'button' => 'Perbarui',
            'action' => site_url('document/update_action/'.$id),
            'DocumentId' => set_value('DocumentId', $row->DocumentId),
            'DocumentCode' => set_value('DocumentCode', $row->DocumentCode),
            'DocumentName' => set_value('DocumentName', $row->DocumentName),
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
        redirect(site_url('document'));
      }

    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[20]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('DocumentId', TRUE));
        } else {
            $data = array(
              'DocumentCode' => $this->input->post('DocumentCode',TRUE),
              'DocumentName' => $this->input->post('DocumentName',TRUE),
              'Description' => $this->input->post('Description',TRUE),
              'LastChangedDate' => date("Y-m-d H:i:s"),
              'LastChangedByUserId' => $this->session->userdata('user_id')
            );

            $this->Document_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('document'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Document'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[20]['Delete']){
        $row = $this->Document_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date('Y-m-d H:i:s'),
                    'DeletedUserId' => $this->session->userdata('userid')
                  );

          $this->Document_model->update($row->DocumentId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('document'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('document'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Document'));
      }
    }

    public function _rules()
    {
    	$this->form_validation->set_rules('DocumentCode', 'documentcode', 'trim|required');
    	$this->form_validation->set_rules('DocumentName', 'documentname', 'trim|required');

    	$this->form_validation->set_rules('DocumentId', 'DocumentId', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Document.php */
/* Location: ./application/controllers/Document.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-04-02 08:29:24 */
/* http://harviacode.com */