<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
Codegraphs
*/
class Getdetailusers {
  protected $CI;

  public function __construct()
  {
    // Assign the CodeIgniter super-object
    $this->CI =& get_instance();
    $this->CI->load->model('Users_model');
  }

  function GetById($id = null, $case = null){
    if($id){
      $data = $this->CI->Users_model->get_by_id($id);
      switch ($case) {
        case 'username':
          $result = $data->username;
          break;
        case 'name':
          $result = $data->name;
          break;
        case 'email':
          $result = $data->email;
          break;
        case 'role':
          $result = $data->role;
          break;
        case 'id':
          $result = $data->id;
          break;
        default:
          $result = null;
          break;
      }
    }else{
      $result = '';
    }
    return $result;
  }

}
