<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author : Tri Wijayanto | wijay11ipa@gmail.com | twitter : @_triwijayanto | instagram : @codegraphs
* Awesome Thanks For Soffi Amalia Ulya
* Pocnauth is CodeIgniter Library for Authentification
*
*/
class Pocnauth {

  protected $CI;

  public function __construct()
  {
    // Assign the CodeIgniter super-object
    $this->CI =& get_instance();
    $this->CI->load->model('authModel');
    $this->CI->load->library('session');
    $this->CI->load->helper('security');
  }

  function doLogin($user, $pass)
  {
    $username  = $this->CI->security->xss_clean($user);
    $password  = $this->CI->security->xss_clean($pass);

    $cek = $this->CI->authModel->cekUser($user, md5($pass)); //melakukan persamaan data dengan database

    if (count($cek) == 1) { //cek data berdasarkan username & pass

      foreach ($cek as $cek) {
        $id       = $cek['id'];
        $name     = $cek['name'];
        $username = $cek['username'];
        $role     = $cek['role'];
        $jabatanid= $cek['JabatanId'];
      }

      // cek akses menu berdasarkan role
      $AccessMenu = $this->CI->authModel->getMenuAccess($role);
      $ArrAccessMenu = array();
      foreach ($AccessMenu as $val) {
        $ArrAccessMenu[$val->MenuId] = array(
                                          'Read' => $val->Read,
                                          'Write' => $val->Write,
                                          'Update' => $val->Update,
                                          'Delete' => $val->Delete
                                          );
      }
      //////////////////////////////////

      // ambil data menu
      $Menu = $this->CI->authModel->getMenu();
      $ParentMenu = array();
      foreach ($Menu as $val) {
        $ParentMenu[$val->MenuId] = $this->CI->authModel->getParentMenu($val->MenuId);
      }
      //////////////////////////////////

      $this->CI->session->set_userdata(
        array(
          'isLogin'   => TRUE,      //set data telah login
          'user_id'    => $id,       //set session id
          'username'  => $username, //set session username
          'full_name' => $name,     //set session name
          'role'      => $role,     //set session role
          'menu'      => $Menu,
          'parentMenu'=> $ParentMenu,
          'access_menu' => $ArrAccessMenu,
          'jabatanid' => $jabatanid
        )
      );

      return TRUE;
    }
    else return FALSE; //jika salah
  }

  public function isLogin()
  {
    if ($this->CI->session->userdata('isLogin') == TRUE) return TRUE;
    else return FALSE;
  }

  public function logout()
  {
    if (substr(CI_VERSION, 0, 1) == '2') $this->CI->session->unset_userdata( array('isLogin' => '', 'userid' => '', 'role' => '') );
    else $this->CI->session->unset_userdata( array('isLogin' => '', 'userid' => '', 'role' => '') );

		$this->CI->session->sess_destroy();

		if (substr(CI_VERSION, 0, 1) == '2') $this->CI->session->sess_create();
		else
		{
			if (version_compare(PHP_VERSION, '7.0.0') >= 0) session_start();

			$this->CI->session->sess_regenerate(TRUE);
		}
		return TRUE;
  }

  public function admin()
  {
    if ($this->CI->session->userdata('role') == "1") return TRUE;
    else return FALSE;
  }

  public function username()
  {
    return $this->CI->session->userdata('username');
  }

  public function user_id()
  {
    return $this->CI->session->userdata('user_id');
  }

  public function full_name()
  {
    return $this->CI->session->userdata('full_name');
  }

  public function change_password($old, $new, $id)
  {
    $old_password = md5($old);
    $row = $this->CI->authModel->get_user($id);

    if ($row->password != $old_password) return $this->CI->session->set_flashdata('status', 'Password Lama Salah');
    elseif ($row->password == $old_password && $row->password == md5($new)) return $this->CI->session->set_flashdata('status', 'Password Lama & Password Baru Tidak Boleh Sama');
    elseif ($row->password == $old_password)
    {
      $this->CI->authModel->reset_password(md5($new), $id);
      return $this->CI->session->set_flashdata('status', 'Berhasil Mengganti Password');
    }
  }

  public function change_password_admin($id, $new)
  {
    if ($this->CI->CI->session->userdata('role') == 1) {
      $row = $this->CI->authModel->get_user($id);
      if ($row->password == md5($new)) return $this->CI->session->flashdata('status', 'Passwod Lama & Password Baru Tidak Boleh Sama');
      elseif ($row->role == 1) return $this->CI->session->flashdata('status', 'Anda Tidak di Izinkan Mengganti Password Admin Lainya');
      else {
        $this->CI->authModel->reset_password($id, md5($new));
        return $this->CI->session->flashdata('status', 'Berhasil Mengganti Password');
      }
    } else {
      return $this->CI->session->flashdata('status', 'Anda Tidak Memiliki Akses!');
    }
  }
}
