<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BudgetRequest_model extends CI_Model
{

    public $table = 'trnbudgetrequest';
    public $sequence = 'seqbudgetrequest';
    public $id = 'BudgetRequestId';
    public $order = 'ASC';

    function __construct()
		{
        parent::__construct();
    }
		
    function getAll()
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
		
    function getById($id)
		{
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
		
    function insert($data)
		{
        $this->db->insert($this->table, $data);
    }
		
    function insertRequest($data)
		{
        $this->db->insert('seqbudgetrequest', $data);
    }
		
    function update($id, $data)
		{
        $this->db->where($this->id, $id);
        return $this->db->update($this->table, $data);
    }

    function updateRequest($id, $data)
		{
        $this->db->where('Id', $id);
        $this->db->update('seqbudgetrequest', $data);
    }    
		
    function delete($id)
		{
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function deleteSeq($id)
		{
        $this->db->where($this->id, $id);
        $this->db->delete($this->sequence);
    }
		
    function getRequest($id)
		{
      $this->db->where($this->id, $id);
      return $this->db->get($this->sequence)->result();
    }

    function lastNoUrut()
		{
      $sql = "SELECT MAX(NoUrut) as NoUrut FROM $this->table";
      return $this->db->query($sql)->result();
    }

    function getDetail($id = NULL)
		{
      $sql = "SELECT a.*, 
										 b.name as CreatorName, 
										 c.JabatanName as CreatorJabatan,
										 d.name as Approval1Name, 
										 e.JabatanName as Approval1Jabatan,
										 f.name as Approval2Name, 
										 g.JabatanName as Approval2Jabatan,
										 h.name as RecipientName, 
										 i.JabatanName as RecipientJabatan
              FROM $this->table a 
              LEFT JOIN users b ON b.id = a.CreatedByUserId
              LEFT JOIN mstjabatan c ON c.JabatanId = b.JabatanId
              LEFT JOIN users d ON d.id = a.Approval1
              LEFT JOIN mstjabatan e ON e.JabatanId = d.JabatanId
              LEFT JOIN users f ON f.id =  a.Approval2
              LEFT JOIN mstjabatan g ON g.JabatanId  = f.JabatanId
              LEFT JOIN users h ON h.id =  a.Recipient
              LEFT JOIN mstjabatan i ON i.JabatanId = h.JabatanId
              WHERE a.BudgetRequestId = '$id'";
      return $this->db->query($sql)->row();
    }

    function approval1Selected($id = NULL)
		{
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Approval1 IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Approval1
              FROM $this->table WHERE BudgetRequestId = '$id') b ON a.id = b.Approval1
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }

    function approval2Selected($id = NULL)
		{
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Approval2 IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Approval2
              FROM $this->table WHERE BudgetRequestId = '$id') b ON a.id = b.Approval2
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }

    function recipientSelected($id = NULL)
		{
      $sql = "SELECT a.id, a.name, c.JabatanName, CASE WHEN (b.Recipient IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM users a LEFT JOIN (SELECT Recipient
              FROM $this->table WHERE BudgetRequestId = '$id') b ON a.id = b.Recipient
              LEFT JOIN mstjabatan c ON a.JabatanId=c.JabatanId
              WHERE a.DeletedDate IS NULL AND a.activation='Active'";

      return $this->db->query($sql)->result();
    }

    function emailToVerificator($Approval1, $Approval2)
		{
      $sql = "SELECT email FROM users WHERE id IN ('".$Approval1."','".$Approval2."')";
      return $this->db->query($sql)->result_array();
    }
}
