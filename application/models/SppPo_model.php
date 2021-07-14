<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SppPo_model extends CI_Model
{

    public $table = 'trnspp';
    public $id = 'SppId';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
      $sql = "SELECT
                  z.SppId, z.NoUrut as SppNoUrut, z.UsedDate as SppUsedDate, z.Approval1Status as ApprovalSpp1Status,
                  z.Approval2Status as ApprovalSpp2Status, z.CreatedByUserId as SppCreateBy,
                  x.PoId, x.NoUrut as PoNoUrut, x.PoDate, x.Approval1Status as ApprovalPo1Status, x.Approval2Status as ApprovalPo2Status,
                  x.CreatedByUserId as PoCreateBy
              FROM trnspp z LEFT JOIN trnpo x ON z.SppId=x.SppId
              WHERE z.DeletedDate IS NULL ORDER BY z.NoUrut";
      return $this->db->query($sql)->result();
    }

    function getSppByProyekId($ProyekId = NULL, $PoId = NULL)
    {
      if($PoId){
        $sql = "SELECT
                    DISTINCT(a.SppId), a.SppNo, CASE WHEN (b.SppId IS NOT NULL) THEN 'checked' ELSE 'null' END AS checked
                FROM trnspp a JOIN (SELECT SppId
                FROM seqrequestspp WHERE PoId='$PoId') b ON a.SppId = b.SppId
                WHERE a.Approval1Status=1 AND a.Approval2Status=1 AND 
                      a.DeletedDate IS NULL ORDER BY a.NoUrut";
      }else{
        $sql = "SELECT
                    DISTINCT(a.SppId), b.SppNo
                FROM seqrequestspp a JOIN trnspp b ON a.SppId=b.SppId 
                WHERE a.PoId IS NULL AND b.ProyekId='$ProyekId' AND b.Approval1Status=1 AND b.Approval2Status=1 AND 
                      b.DeletedDate IS NULL ORDER BY b.NoUrut";
      }
      return $this->db->query($sql)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_po_by_id($id)
    {
        $this->db->where('PoId', $id);
        return $this->db->get('trnpo')->row();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        $sql = "
          INSERT INTO seqagreementstatus (Agreement, AgreementId, JabatanId)
          (
            SELECT 'SPP', '".$data['SppId']."', JabatanId FROM grpverificatoragreement a 
            WHERE a.Agreement='SPP'
          )
        ";
        $this->db->query($sql);
    }

    function insertPo($data)
    {
        $this->db->insert('trnpo', $data);
        $sql = "
          INSERT INTO seqagreementstatus (Agreement, AgreementId, JabatanId)
          (
            SELECT 'PO', '".$data['PoId']."', JabatanId FROM grpverificatoragreement a 
            WHERE a.Agreement='PO'
          )
        ";
        $this->db->query($sql);
    }

    // insert data request
    function insertRequestSpp($data)
    {
        $this->db->insert('seqrequestspp', $data);
    }

    function insertRequestPo($data)
    {
        $this->db->insert('seqrequestpo', $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        return $this->db->update($this->table, $data);
    }

    function updatePo($id, $data)
    {
        $this->db->where('PoId', $id);
        return $this->db->update('trnpo', $data);
    }

    function updateRequestSpp($id, $data){
        $this->db->where('Id', $id);
        $this->db->update('seqrequestspp', $data);
    }    

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // delete data Request Spp
    function deleteRequestSpp($id)
    {
        $this->db->where('SppId', $id);
        $this->db->delete('seqrequestspp');
    }

    function deleteRequestPo($id)
    {
        $this->db->where('PoId', $id);
        $this->db->delete('seqrequestpo');
    }

    // get spp Request
    function getRequestSpp($id){
      $this->db->where('SppId', $id);
      return $this->db->get('seqrequestspp')->result();
    }

    // get spp Request
    function getRequestSppPo($id){
      $sql = "SELECT * FROM seqrequestspp WHERE SppId='$id' AND PoId IS NULL";
      return $this->db->query($sql)->result();
    }

    // set null PoId on seqrequestspp by PoId
    function setNullRequestSppPoByPoId($PoId){
      $sql = "UPDATE seqrequestspp a set a.PoId = NULL WHERE a.PoId='$PoId'";
      $this->db->query($sql);
    }

    // get po Request
    function getRequestPo($id){
      //$this->db->where('PoId', $id);
      //return $this->db->get('seqrequestspp')->result();
      $sql = "SELECT 
                Id, SppId, Sort, ResourceCode, QuantitySpp, Unit, Item, Spesification, WorkFor,
                CASE WHEN (PoIdTolak is null) THEN PoId ELSE PoIdTolak END PoId,
                CASE WHEN (QuantityPoTolak is null) THEN QuantityPo ELSE QuantityPoTolak END QuantityPo,
                CASE WHEN (PriceTolak is null) THEN Price ELSE PriceTolak END Price,
                CASE WHEN (AmountTolak is null) THEN Amount ELSE AmountTolak END Amount
              FROM seqrequestspp
              WHERE PoId = '".$id."' OR PoIdTolak = '".$id."'
";
      return $this->db->query($sql)->result();
    }

    function proyekSelected($id = NULL){
      $sql = "SELECT a.ProyekId, a.ProyekCode, a.ProyekName, CASE WHEN (b.ProyekId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM trnproyek a LEFT JOIN (SELECT ProyekId
              FROM $this->table WHERE SppId='$id') b ON a.ProyekId = b.ProyekId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function proyekPoSelected($id = NULL){
      $sql = "SELECT a.ProyekId, a.ProyekCode, a.ProyekName, CASE WHEN (b.ProyekId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM trnproyek a LEFT JOIN (SELECT ProyekId
              FROM trnpo WHERE PoId='$id') b ON a.ProyekId = b.ProyekId
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

    function getDetailSpp($SppId = NULL){
      $sql = "SELECT a.*, b.ProyekName, c.name as Approval1, d.JabatanName as JabatanApproval1,
                     e.name as Approval2, f.JabatanName as JabatanApproval2, c.TtdHard as TtdHard1, e.TtdHard as TtdHard2
              FROM trnspp a INNER JOIN trnproyek b ON (a.ProyekId=b.ProyekId)
              LEFT JOIN users c ON a.Approval1=c.id
              LEFT JOIN mstjabatan d ON c.JabatanId=d.JabatanId
              LEFT JOIN users e ON a.Approval2=e.id
              LEFT JOIN mstjabatan f ON e.JabatanId=f.JabatanId
              WHERE a.SppId='$SppId'";
      return $this->db->query($sql)->row();
    }

    function getDetailPo($PoId = NULL){
      $sql = "SELECT a.*, c.ProyekName, c.ProyekDescription ,d.VendorName, d.Address1, e.name as Approval1, f.JabatanName as JabatanApproval1,
                     g.name as Approval2, h.JabatanName as JabatanApproval2
                FROM trnpo a
                  -- LEFT JOIN trnspp b ON (a.SppId=b.SppId)
                  LEFT JOIN trnproyek c ON (a.ProyekId=c.ProyekId)
                  LEFT JOIN mstvendor d ON (a.VendorId=d.VendorId)
                  LEFT JOIN users e ON a.Approval1=e.id
                  LEFT JOIN mstjabatan f ON e.JabatanId=f.JabatanId
                  LEFT JOIN users g ON a.Approval2=g.id
                  LEFT JOIN mstjabatan h ON g.JabatanId=h.JabatanId
              WHERE a.PoId='$PoId'";
      return $this->db->query($sql)->row();
    }

    function approval1Selected($id = NULL){
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Approval1 IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Approval1
              FROM $this->table WHERE SppId='$id') b ON a.id = b.Approval1
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }

    function approval2Selected($id = NULL){
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Approval2 IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Approval2
              FROM $this->table WHERE SppId='$id') b ON a.id = b.Approval2
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }

    function approvalPo1Selected($id = NULL){
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Approval1 IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Approval1
              FROM trnpo WHERE PoId='$id') b ON a.id = b.Approval1
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }

    function approvalPo2Selected($id = NULL){
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Approval2 IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Approval2
              FROM trnpo WHERE PoId='$id') b ON a.id = b.Approval2
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }
    
    function updateSeqRequestSppPoTolak($PoId)
    {
        $sql = "
                Update seqrequestspp
                set PoIdTolak = PoId, 
                    QuantityPoTolak = QuantityPo, 
                    PriceTolak = Price, 
                    AmountTolak = Amount,
                    PoId = 'NULL', 
                    QuantityPo = 'NULL', 
                    Price = 'NULL', 
                    Amount = 'NULL' 
                    
                WHERE PoId = '".$PoId."'
                ";
        // var_dump($sql); exit();
        $this->db->query($sql);
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
