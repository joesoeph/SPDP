<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AgreementType extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('AgreementType_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->Content = 'content/agreementTypeList'; // url content yang akan diload\
        // jika ada plugin tambahan untuk page ini masukan didalam array
        $Datas['AddCss'] = [];
        $Datas['AddJsHeader'] = [];
        $Datas['AddJsFooter'] = [];
        //==============================================================//
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[17]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = $agreementtype = $this->AgreementType_model->get_all(); // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah
        }
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function read($id)
    {
        $this->Content = 'content/agreementTypeForm'; // url content yang akan diload\
        // jika ada plugin tambahan untuk page ini masukan didalam array
        $Datas['AddCss'] = [];
        $Datas['AddJsHeader'] = [];
        $Datas['AddJsFooter'] = [];
        //==============================================================//

        $row = $this->AgreementType_model->get_by_id($id);
        if ($row) {
          $arrAccessMenu = $this->session->userdata('access_menu');
          if(!$arrAccessMenu[17]['Read']){
            $this->Content = 'errors/dontHaveAccess';
          } else {
             $Datas['ArrData'] = array(
                'button' => '',
                'action' => site_url('AgreementType/create_action'),
            	  'AgreementTypeId' => $row->AgreementTypeId,
            		'AgreementTypeName' => $row->AgreementTypeName,
            		'Pph' => $row->Pph,
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
          redirect(site_url('AgreementType'));
        }
    }

    public function create()
    {
       $this->Content = 'content/agreementTypeForm'; // url content yang akan diload\
       // jika ada plugin tambahan untuk page ini masukan didalam array
       $Datas['AddCss'] = [];
       $Datas['AddJsHeader'] = [];
       $Datas['AddJsFooter'] = [];
       //==============================================================//
       $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[17]['Write']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
                              'button' => 'Simpan',
                              'action' => site_url('AgreementType/create_action'),
                         	    'AgreementTypeId' => set_value('AgreementTypeId'),
                         	    'AgreementTypeName' => set_value('AgreementTypeName'),
                         	    'Pph' => set_value('Pph'),
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
      if($arrAccessMenu[17]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                  		'AgreementTypeName' => $this->input->post('AgreementTypeName',TRUE),
                  		'Pph' => $this->input->post('Pph',TRUE),
                  		'CreatedDate' => date("Y-m-d H:i:s"),
                  		'CreatedByUserId' => $this->session->userdata('user_id')
	                   );

            $this->AgreementType_model->insert($data);
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('AgreementType'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('AgreementType'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/agreementTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $row = $this->AgreementType_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[17]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
                              'button' => 'Perbarui',
                              'action' => site_url('AgreementType/update_action'),
                              'AgreementTypeId' => set_value('AgreementTypeId', $row->AgreementTypeId),
                              'AgreementTypeName' => set_value('AgreementTypeName', $row->AgreementTypeName),
                              'Pph' => set_value('Pph', $row->Pph),
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
        redirect(site_url('AgreementType'));
      }
    }

    public function update_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[17]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('AgreementTypeId', TRUE));
        } else {
            $data = array(
                  		'AgreementTypeName' => $this->input->post('AgreementTypeName',TRUE),
                  		'Pph' => $this->input->post('Pph',TRUE),
                  		'LastChangedDate' => date("Y-m-d H:i:s"),
                  		'LastChangedByUserId' => $this->session->userdata('user_id')
                    );

            $this->AgreementType_model->update($this->input->post('AgreementTypeId', TRUE), $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('AgreementType'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('AgreementType'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[17]['Delete']){
        $row = $this->AgreementType_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date("Y-m-d H:i:s"),
                    'DeletedUserId' => $this->session->userdata('user_id')
                  );

          $this->AgreementType_model->update($row->AgreementTypeId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('AgreementType'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('agreementtype'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('AgreementType'));
      }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('AgreementTypeName', 'agreementtypename', 'trim|required');
      	$this->form_validation->set_rules('Pph', 'pph', 'trim|required');;

      	$this->form_validation->set_rules('AgreementTypeId', 'AgreementTypeId', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file AgreementType.php */
/* Location: ./application/controllers/AgreementType.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 04:28:09 */
/* http://harviacode.com */
