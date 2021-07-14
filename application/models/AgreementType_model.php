<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AgreementType_model extends CI_Model
{

    public $table = 'mstagreementtype';
    public $id = 'AgreementTypeId';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->where(array('DeletedDate' => NULL));
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function notification()
    {
      $query = $this->db->query("SELECT AgreementId, AgreementTypeId FROM trnagreement AS A WHERE (A.Date - cast(now() as date)) <= 7 AND A.PrintStatus = 0");
      return $query->result();
    }

}

/* End of file AgreementType_model.php */
/* Location: ./application/models/AgreementType_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-12 04:28:10 */
/* http://harviacode.com */
