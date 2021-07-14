<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->tbl = "users";
	}

	function cekUser($username="", $password="")
	{
		$query = $this->db->get_where($this->tbl,array('username' => $username, 'password' => $password, 'activation' => 'Active'));
		$query = $query->result_array();
		return $query;
	}

	function getUser($username, $where)
  {
    $query = $this->db->get_where($this->tbl, array('username' => $username, 'id' => $where));
    $query = $query->result_array();
    if($query)
    {
      return $query[0];
    }
  }

	function get_user($where)
  {
    return $this->db->get_where($this->tbl, array('id' => $where))->row();

  }

  function addUser($data)
  {
    $this->db->insert($this->tbl, $data);
  }

  function cek_password($nrp = "", $password_lama = "")
  {
    $query = $this->db->get_where(
      $this->tbl,
      array(
        'nrp'      => $nrp,
        'password' => $password_lama
      )
    );

    $query = $query->result();
    return $query;
  }

  function reset_password($data, $where)
	{
		$this->db->where('id', $where);
		$a = $this->db->update($this->tbl, array('password' => $data));
		return $a;
	}

  function getMenuAccess($RoleId){
    return $this->db->get_where('menuaccess', ['RoleId' => $RoleId])->result();
  }

  function getMenu(){
    return $this->db->order_by('MenuSort', 'ASC')->get_where('menu', ['Parent' => NULL, 'Active' => 1])->result();
  }

  function getParentMenu($Parent){
    return $this->db->order_by('MenuSort', 'ASC')->get_where('menu', ['Parent' => $Parent, 'Active' => 1])->result();
  }

  function updateAccessMenu($RoleId, $MenuId, $data)
  {
    $this->db->where(['RoleId' => $RoleId, 'MenuId' => $MenuId]);
    return $this->db->update('menuaccess', $data);
  }

  function insertAccessMenu($data)
  {
    return $this->db->insert('menuaccess', $data);
  }
}
