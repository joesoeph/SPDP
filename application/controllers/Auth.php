<?php

if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('pocnauth');
  }

  public function index()
  {
    $session = $this->session->userdata('isLogin'); //mengabil dari session apakah sudah login atau belum
    if ($session == false) {
    //jika session false maka akan menampilkan halaman login
      //$this->load->view('template/login');
      $this->load->view('template/login-2');
    } else {
    //jika session true maka di redirect ke halaman dashboard
      redirect('dashboard');
    }
  }

  function doLogin()
  {
    if ($this->input->post('username') == "" && $this->input->post('password') == "") {
      redirect('auth');
    }

    if ($this->pocnauth->doLogin($this->input->post('username'), $this->input->post('password')) == TRUE) {
      redirect('dashboard');
    } else {
      redirect('auth');
    }
  }

  public function logout()
  {
    $this->pocnauth->logout();
    redirect('auth');
  }

  function changePassword(){
    $userid = $this->input->post('userid');
    $oldpassword = $this->input->post('oldpassword');
    $newpassword = $this->input->post('newpassword');
    $confirmpassword = $this->input->post('confirmpassword');
    if($newpassword != $confirmpassword){
      $respons = 'Password Baru Tidak Sama';
   }else{
     $this->pocnauth->change_password($oldpassword, $newpassword, $userid);
     $respons = $this->session->flashdata('status');
   }

   echo json_encode(array('message' => $respons));
  }

}
