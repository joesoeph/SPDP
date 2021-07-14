<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SppBtl_model extends CI_Model
{

    public $table = 'trnsppbtl';
    public $id = 'SppBtlId';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
      $this->db->where(array('DeletedDate' => NULL));
        $this->db->order_by('NoUrut', $this->order);
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
        $sql = "
          INSERT INTO seqagreementstatus (Agreement, AgreementId, JabatanId)
          (
            SELECT 'BTL', '".$data['SppBtlId']."', JabatanId FROM grpverificatoragreement a 
            WHERE a.Agreement='BTL'
          )
        ";
        $this->db->query($sql);
    }

    // insert data request
    function insertRequestSppBtl($data)
    {
        $this->db->insert('seqrequestsppbtl', $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        return $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // delete data Request Spp
    function deleteRequestSppBtl($id)
    {
        $this->db->where('SppBtlId', $id);
        $this->db->delete('seqrequestsppbtl');
    }


    // get spp Request
    function getRequestSppBtl($id){
      $this->db->where('SppBtlId', $id);
      return $this->db->get('seqrequestsppbtl')->result();
    }

    function proyekSelected($id = NULL){
      $sql = "SELECT a.ProyekId, a.ProyekCode, a.ProyekName, CASE WHEN (b.ProyekId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM trnproyek a LEFT JOIN (SELECT ProyekId
              FROM $this->table WHERE SppBtlId='$id') b ON a.ProyekId = b.ProyekId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function vendorSelected($id = NULL){
      $sql = "SELECT a.VendorId, a.VendorName, CASE WHEN (b.VendorId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstvendor a LEFT JOIN (SELECT VendorId
              FROM trnpo WHERE PoId='$id') b ON a.VendorId = b.VendorId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function sppLanstNuUrut(){
      $sql = "SELECT MAX(NoUrut) as NoUrut FROM $this->table";
      return $this->db->query($sql)->result();
    }

    function poLanstNuUrut(){
      $sql = "SELECT MAX(NoUrut) as NoUrut FROM trnpo";
      return $this->db->query($sql)->result();
    }

    function getDetailSppBtl($SppBtlId = NULL){
      $sql = "SELECT a.*, b.ProyekName, c.name as Approval1, d.JabatanName as JabatanApproval1,
                     e.name as Approval2, f.JabatanName as JabatanApproval2, c.TtdHard as TtdHard1, e.TtdHard as TtdHard2 
              FROM trnsppbtl a INNER JOIN trnproyek b ON (a.ProyekId=b.ProyekId)
              LEFT JOIN users c ON a.Approval1=c.id
              LEFT JOIN mstjabatan d ON c.JabatanId=d.JabatanId
              LEFT JOIN users e ON a.Approval2=e.id
              LEFT JOIN mstjabatan f ON e.JabatanId=f.JabatanId
              WHERE a.SppBtlId='$SppBtlId'";
      return $this->db->query($sql)->row();
    }

    function approval1Selected($id = NULL){
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Approval1 IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Approval1
              FROM $this->table WHERE SppBtlId='$id') b ON a.id = b.Approval1
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }

    function approval2Selected($id = NULL){
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Approval2 IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Approval2
              FROM $this->table WHERE SppBtlId='$id') b ON a.id = b.Approval2
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }
    
    function email_to_verificator($Approval1, $Approval2)
    {
      $sql = "SELECT email FROM users WHERE id IN ('".$Approval1."','".$Approval2."')";
      return $this->db->query($sql)->result_array();
    }

}

/* End of file SppPo_model.php */
/* Location: ./application/models/SppPo_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-23 07:26:43 */
/* http://harviacode.com */
