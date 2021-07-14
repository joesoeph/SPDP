<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PaymentType extends Parent_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('PaymentType_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
      $this->Content = 'content/paymentTypeList'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];

      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[15]['Read']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        //==============================================================//
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'paymentType/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'paymentType/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'paymentType/index.html';
            $config['first_url'] = base_url() . 'paymentType/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->PaymentType_model->total_rows($q);
        $paymenttype = $this->PaymentType_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'data' => $paymenttype,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $Datas['ArrData'] = $data; // data hasil proses masukan ke array ini untuk dirender di view, index 'ArrData' bisa dirubah
      }
      $this->Layouts($Datas); // Layouts adalah template dashboard admin

    }

    public function read($id)
    {
      $this->Content = 'content/paymentTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//

      $row = $this->PaymentType_model->get_by_id($id);
      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[15]['Read']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
           $Datas['ArrData'] = array(
              'button' => '',
              'action' => site_url('PaymentType/create_action'),
              'PaymentTypeId' => $row->PaymentTypeId,
          		'PaymentTypeCode' => $row->PaymentTypeCode,
          		'PaymentTypeName' => $row->PaymentTypeName,
          );
        }
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('PaymentType'));
      }
    }

    public function create()
    {
      $this->Content = 'content/paymentTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $arrAccessMenu = $this->session->userdata('access_menu');
      if(!$arrAccessMenu[15]['Write']){
        $this->Content = 'errors/dontHaveAccess';
      } else {
        $Datas['ArrData'] = array(
            'button' => 'Simpan',
            'action' => site_url('paymentType/create_action'),
            'PaymentTypeId' => set_value('PaymentTypeId'),
            'PaymentTypeCode' => set_value('PaymentTypeCode'),
            'PaymentTypeName' => set_value('PaymentTypeName'),
        );
      }
      $this->Layouts($Datas); // Layouts adalah template dashboard admin

    }

    public function create_action()
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[15]['Write']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'PaymentTypeCode' => $this->input->post('PaymentTypeCode',TRUE),
              'PaymentTypeName' => $this->input->post('PaymentTypeName',TRUE),
            );

            $this->PaymentType_model->insert($data);
            $this->session->set_flashdata('message', 'Data disimpan');
            redirect(site_url('PaymentType'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PaymentType'));
      }
    }

    public function update($id)
    {
      $this->Content = 'content/paymentTypeForm'; // url content yang akan diload\
      // jika ada plugin tambahan untuk page ini masukan didalam array
      $Datas['AddCss'] = [];
      $Datas['AddJsHeader'] = [];
      $Datas['AddJsFooter'] = [];
      //==============================================================//
      $row = $this->PaymentType_model->get_by_id($id);

      if ($row) {
        $arrAccessMenu = $this->session->userdata('access_menu');
        if(!$arrAccessMenu[15]['Update']){
          $this->Content = 'errors/dontHaveAccess';
        } else {
          $Datas['ArrData'] = array(
              'button' => 'Perbarui',
              'action' => site_url('paymentType/update_action/'.$id),
              'PaymentTypeId' => set_value('PaymentTypeId', $row->PaymentTypeId),
              'PaymentTypeCode' => set_value('PaymentTypeCode', $row->PaymentTypeCode),
              'PaymentTypeName' => set_value('PaymentTypeName', $row->PaymentTypeName),
          );
        }
        $this->Layouts($Datas); // Layouts adalah template dashboard admin
      } else {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('PaymentType'));
      }

    }

    public function update_action($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[15]['Update']){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
          		'PaymentTypeCode' => $this->input->post('PaymentTypeCode',TRUE),
          		'PaymentTypeName' => $this->input->post('PaymentTypeName',TRUE),
          	);

            $this->PaymentType_model->update($id, $data);
            $this->session->set_flashdata('message', 'Data diperbarui');
            redirect(site_url('PaymentType'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PaymentType'));
      }
    }

    public function delete($id)
    {
      $arrAccessMenu = $this->session->userdata('access_menu');
      if($arrAccessMenu[15]['Delete']){
        $row = $this->PaymentType_model->get_by_id($id);

        if ($row) {
            $this->PaymentType_model->delete($id);
            $this->session->set_flashdata('message', 'Data telah dihapus');
            redirect(site_url('PaymentType'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('PaymentType'));
        }
      } else {
        $this->session->set_flashdata('message', 'Anda tidak punya akses');
        redirect(site_url('PaymentType'));
      }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('PaymentTypeCode', 'paymenttypecode', 'trim|required');
      	$this->form_validation->set_rules('PaymentTypeName', 'paymenttypename', 'trim|required');

      	$this->form_validation->set_rules('PaymentTypeId', 'PaymentTypeId', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file PaymentType.php */
/* Location: ./application/controllers/PaymentType.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 08:58:18 */
/* http://harviacode.com */
