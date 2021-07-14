<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monitor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Payment_model', 'PenerimaanInvoice_model'));
    }

    public function index()
    {
      // var_dump($_POST);
      if ($this->input->post() && ($this->input->post('secutity_code') == $this->session->userdata('mycaptcha'))) {
        // echo $this->input->post('secutity_code')." ".$this->session->userdata('mycaptcha');exit();
        $this->load->view('template/monitorForm.php');
      } else {
        // load codeigniter captcha helper
        $this->load->helper('captcha');
        $vals = array(
            'img_path'   => './captcha/',
            'img_url'  => base_url().'captcha/',
            'img_width'  => '200',
            'img_height' => 30,
            'border' => 0, 
            'expiration' => 7200
        );
        // create captcha image
        $cap = create_captcha($vals);
        // store image html code in a variable
        $data['image'] = $cap['image'];

        // store the captcha word in a session
        $this->session->set_userdata('mycaptcha', $cap['word']);
        $this->load->view('template/captcha.php', $data);
      }
    }

    public function Search(){
      $Keyword = $this->input->post('keyword', TRUE);
      $DataInvoice = $this->Payment_model->searchInvoice($Keyword);
      if($DataInvoice){
        echo json_encode($DataInvoice);
      }else{
        echo false;
      }
    }

    public function detailPembayaran(){
      $PenerimaanInvoiceId = $this->input->post('id', TRUE);
      $DataPembayaran = $this->Payment_model->getDetailPembayaran($PenerimaanInvoiceId);
      $DataInvoice    = $this->Payment_model->getInvoiceById($PenerimaanInvoiceId);
      $DataLampiran   = $this->PenerimaanInvoice_model->getLampiran($PenerimaanInvoiceId);
      echo json_encode(
        array(
          'DataInvoice' => $DataInvoice, 
          'DataPembayaran' => $DataPembayaran,
          'DataLampiran' => $DataLampiran
        )
      );
    }

}

/* End of file Monitor.php */
/* Location: ./application/controllers/Monitor.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-23 07:26:43 */
/* http://harviacode.com */
