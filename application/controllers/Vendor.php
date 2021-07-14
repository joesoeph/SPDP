<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendor extends Parent_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Vendor_model', 'GlobalModel'));
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/vendorList'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[16]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = $this->Vendor_model->get_all(); // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah
      }
      $this->Layouts($Datas); // Layouts adalah template dashboard admin
    }

    public function read($id)
    {
      $this->Content = 'content/vendorForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $row = $this->Vendor_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[16]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('Vendor/create_action'),
              'VendorId' => $row->VendorId,
          		'VendorCode' => $row->VendorCode,
          		'VendorName' => $row->VendorName,
          		'Address1' => $row->Address1,
          		'Telp' => $row->Telp,
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
        redirect(site_url('Vendor'));
      }

    }

    public function create()
    {
      $this->Content = 'content/vendorForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[16]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
                            'button' => 'Simpan',
                            'action' => site_url('vendor/create_action'),
                       	    'VendorId' => set_value('VendorId'),
                       	    'VendorCode' => set_value('VendorCode'),
                       	    'VendorName' => set_value('VendorName'),
                       	    'Address1' => set_value('Address1'),
                       	    'Telp' => set_value('Telp'),
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
      if($arrAccessMenu[16]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $exst = $this->GlobalModel->getDataByWhere('mstvendor', array('VendorCode' => preg_replace('/\s+/', '', $this->input->post('VendorCode',TRUE))));
            if($exst){
              $this->session->set_flashdata('message', 'Kode vendor sudah ada');
              redirect(site_url('Vendor/update/'.$exst->VendorId));
            }
            else
            {
                $data = array(
                      'VendorCode' => $this->input->post('VendorCode',TRUE),
                      'VendorName' => $this->input->post('VendorName',TRUE),
                      'Address1' => $this->input->post('Address1',TRUE),
                      'Telp' => $this->input->post('Telp',TRUE),
                      'CreatedDate' => date("Y-m-d H:i:s"),
                      'CreatedByUserId' => $this->session->userdata('user_id')
                     );
                $this->Vendor_model->insert($data);
                $this->session->set_flashdata('message', 'Data disimpan');
                redirect(site_url('Vendor'));
            }
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Vendor'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/vendorForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $row = $this->Vendor_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[16]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
                              'button' => 'Perbarui',
                              'action' => site_url('Vendor/update_action/'.$row->VendorId),
                                'VendorCode' => set_value('VendorCode', $row->VendorCode),
                          		'VendorName' => set_value('VendorName', $row->VendorName),
                          		'Address1' => set_value('Address1', $row->Address1),
                          		'Telp' => set_value('Telp', $row->Telp),
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
        redirect(site_url('Vendor'));
      }
    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[16]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
                      'VendorCode' => $this->input->post('VendorCode',TRUE),
                      'VendorName' => $this->input->post('VendorName',TRUE),
                      'Address1' => $this->input->post('Address1',TRUE),
                      'Telp' => $this->input->post('Telp',TRUE),
                      'LastChangedDate' => date("Y-m-d H:i:s"),
                      'LastChangedByUserId' => $this->session->userdata('user_id'),
                    );

            $this->Vendor_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('Vendor'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Vendor'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[16]['Delete']){
        $row = $this->Vendor_model->get_by_id($id);

        if ($row) {
          $data = array(
                    'DeletedDate' => date("Y-m-d H:i:s"),
                    'DeletedUserId' => $this->session->userdata('user_id')
                  );

          $this->Vendor_model->update($row->VendorId, $data);

          $this->session->set_flashdata('message', 'Data telah dihapus');
          redirect(site_url('Vendor'));
        } else {
          $this->session->set_flashdata('message', 'Data tidak ditemukan');
          redirect(site_url('Vendor'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('Vendor'));
      }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('VendorCode', 'vendorcode', 'trim|required');
    	$this->form_validation->set_rules('VendorName', 'vendorname', 'trim|required');
    	$this->form_validation->set_rules('Address1', 'address1', 'trim|required');
    	$this->form_validation->set_rules('Telp', 'telp', 'trim|required');
    	

    	$this->form_validation->set_rules('VendorId', 'VendorId', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Vendor.php */
/* Location: ./application/controllers/Vendor.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 06:48:29 */
/* http://harviacode.com */
