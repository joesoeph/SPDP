<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PenerimaanInvoice_model extends CI_Model
{

    public $table = 'trnpenerimaaninvoice';
    public $id    = 'PenerimaanInvoiceId';
    public $order = 'DESC';

    public $tableSeqDocument = 'seqpenerimaaninvoicedocument';
    public $tableSeqVerification = 'seqpenerimaaninvoiceverification';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select('a.*,b.ProyekCode, b.ProyekName, c.VendorName, d.BillTypeCode, d.BillTypeName,
               e.PaymentTypeCode, e.PaymentTypeName, f.PpnName, f.PpnValue, g.PphName, g.PphValue');
        $this->db->join('trnproyek b', 'b.ProyekId = a.ProyekId', 'LEFT');
        $this->db->join('mstvendor c', 'c.VendorId = a.VendorId', 'LEFT');
        $this->db->join('mstbilltype d', 'd.BillTypeId = a.BillTypeId', 'LEFT');
        $this->db->join('mstpaymenttype e', 'e.PaymentTypeId = a.PaymentTypeId', 'LEFT');
        $this->db->join('mstppntagihan f', 'f.PpnId = a.PpnId', 'LEFT');
        $this->db->join('mstpphtagihan g', 'g.PphId = a.PphId', 'LEFT');
        $this->db->where(array('a.DeletedDate' => NULL));
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table.' a')->result();
    }

    // get pending dokument
    function get_pendingDocument()
    {
        $sql = "
        SELECT a.*, b.ProyekCode, b.ProyekName, c.VendorName, d.BillTypeCode, d.BillTypeName, e.PaymentTypeCode, e.PaymentTypeName, f.PpnName, f.PpnValue, g.PphName, g.PphValue
        FROM (select distinct(PenerimaanInvoiceId) from seqpenerimaaninvoicedocument where Path is null or Path = '') h
        JOIN trnpenerimaaninvoice a ON h.PenerimaanInvoiceId = a.PenerimaanInvoiceId
        LEFT JOIN trnproyek b ON b.ProyekId = a.ProyekId
        LEFT JOIN mstvendor c ON c.VendorId = a.VendorId
        LEFT JOIN mstbilltype d ON d.BillTypeId = a.BillTypeId
        LEFT JOIN mstpaymenttype e ON e.PaymentTypeId = a.PaymentTypeId
        LEFT JOIN mstppntagihan f ON f.PpnId = a.PpnId
        LEFT JOIN mstpphtagihan g ON g.PphId = a.PphId
        WHERE a.DeletedDate IS NULL
        ORDER BY PenerimaanInvoiceId DESC
        ";
        $result = $this->db->query($sql)->result();

        return $result;
    }

    // get pending verifikasi
    function get_pendingVerification()
    {
        $sql = "
        SELECT a.*, b.ProyekCode, b.ProyekName, c.VendorName, d.BillTypeCode, d.BillTypeName, e.PaymentTypeCode, e.PaymentTypeName, f.PpnName, f.PpnValue, g.PphName, g.PphValue
        FROM (select distinct(PenerimaanInvoiceId) from seqpenerimaaninvoiceverification where VerificationDate is null) h
        JOIN trnpenerimaaninvoice a ON h.PenerimaanInvoiceId = a.PenerimaanInvoiceId
        LEFT JOIN trnproyek b ON b.ProyekId = a.ProyekId
        LEFT JOIN mstvendor c ON c.VendorId = a.VendorId
        LEFT JOIN mstbilltype d ON d.BillTypeId = a.BillTypeId
        LEFT JOIN mstpaymenttype e ON e.PaymentTypeId = a.PaymentTypeId
        LEFT JOIN mstppntagihan f ON f.PpnId = a.PpnId
        LEFT JOIN mstpphtagihan g ON g.PphId = a.PphId
        WHERE a.DeletedDate IS NULL
        ORDER BY PenerimaanInvoiceId DESC
        ";
        $result = $this->db->query($sql)->result();

        return $result;
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function getPenerimaanInvoiceByPenerimaanInvoiceId($id)
    {
         $this->db->select('a.*,b.ProyekCode, b.ProyekName, c.VendorName, d.BillTypeCode, d.BillTypeName,
                e.PaymentTypeCode, e.PaymentTypeName, f.PpnName, f.PpnValue, g.PphName, g.PphValue');
        $this->db->join('trnproyek b', 'b.ProyekId = a.ProyekId', 'LEFT');
        $this->db->join('mstvendor c', 'c.VendorId = a.VendorId', 'LEFT');
        $this->db->join('mstbilltype d', 'd.BillTypeId = a.BillTypeId', 'LEFT');
        $this->db->join('mstpaymenttype e', 'e.PaymentTypeId = a.PaymentTypeId', 'LEFT');
        $this->db->join('mstppntagihan f', 'f.PpnId = a.PpnId', 'LEFT');
        $this->db->join('mstpphtagihan g', 'g.PphId = a.PphId', 'LEFT');
        $this->db->where(array('a.PenerimaanInvoiceId' => $id));
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table.' a')->row();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);

        $sql = "INSERT INTO seqpenerimaaninvoicedocument (PenerimaanInvoiceId, DocumentId)
                (
                  SELECT '".$data['PenerimaanInvoiceId']."', DocumentId FROM grpbilldocument
                  WHERE BillTypeId = '".$data['BillTypeId']."'
                )";
        // var_dump($sql); exit();
        $this->db->query($sql);

        $sql = "INSERT INTO seqpenerimaaninvoiceverification(PenerimaanInvoiceId, DocumentId, JabatanId)
                (
                  SELECT '".$data['PenerimaanInvoiceId']."', DocumentId, JabatanId FROM grpbilldocument, grpverificator
                  WHERE BillTypeId = '".$data['BillTypeId']."' AND ProyekId='".$data['ProyekId']."'
                )";
        $this->db->query($sql);
        
        //var_dump($sql); exit();

        $sql = "INSERT INTO seqpenerimaaninvoicestatus (PenerimaanInvoiceId, JabatanId)
                (
                  SELECT '".$data['PenerimaanInvoiceId']."', JabatanId FROM grpverificator WHERE ProyekId='".$data['ProyekId']."'
                )";

        $this->db->query($sql);
    }

    function cekCompletedDocumentVerification($id, $JabatanId){
      $sql = "SELECT A.PenerimaanInvoiceId, A.JabatanId, A.Status, A.StatusDate, A.Note, A.StatusByUserId, B.name StatusByName, 
                B.TtdHard, A.Ttd,
                (SELECT count(0) FROM seqpenerimaaninvoicedocument WHERE PenerimaanInvoiceId = '$id') TotVerificationDocument,
                (SELECT count(0) FROM seqpenerimaaninvoiceverification WHERE PenerimaanInvoiceId = '$id' AND JabatanId = '$JabatanId' AND Status > 0 ) TotVerificationDocumentCompleted
             FROM seqpenerimaaninvoicestatus A
             LEFT JOIN users B on A.StatusByUserId = B.id
             WHERE A.PenerimaanInvoiceId = '$id' AND A.JabatanId = '$JabatanId'";
      return $this->db->query($sql)->row();          
    }


    function InvoiceVerification($id, $JabatanId, $data){
      $this->db->where(['PenerimaanInvoiceId' => $id, 'JabatanId' => $JabatanId]);
      $this->db->update('seqpenerimaaninvoicestatus', $data);
      
      if($data['Status']==2)
      { 
         $sql = "UPDATE
                trnpenerimaaninvoice
              SET
                LockDate = NULL,
                LockByUserId = NULL
              WHERE PenerimaanInvoiceId = '".$id."'
              ";

        $this->db->query($sql);
      }
    }

    function getPenerimaanInvoiceStatusByPenerimaanInvoiceId($PenerimaanInvoiceId){
      $sql = "SELECT A.PenerimaanInvoiceId, A.JabatanId, A.StatusDate, A.Status, A.Note, A.StatusByUserId, B.name as StatusByName
              FROM seqpenerimaaninvoicestatus A
              LEFT JOIN users B ON A.StatusByUserId = B.id
              where A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
              ";
      return $this->db->query($sql)->row();
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

    function vendorSelected($id = NULL){
      $sql = "SELECT a.VendorId, a.VendorName, a.VendorCode, CASE WHEN (b.VendorId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstvendor a LEFT JOIN (SELECT VendorId
              FROM $this->table WHERE PenerimaanInvoiceId='$id') b ON a.VendorId = b.VendorId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function proyekSelected($id = NULL){
      $sql = "SELECT a.ProyekId, a.ProyekCode, a.ProyekName, CASE WHEN (b.ProyekId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM trnproyek a LEFT JOIN (SELECT ProyekId
              FROM $this->table WHERE PenerimaanInvoiceId='$id') b ON a.ProyekId = b.ProyekId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function ppnSelected($id = NULL){
      $sql = "SELECT a.PpnId, a.PpnName, a.PpnValue, CASE WHEN (b.PpnId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstppntagihan a LEFT JOIN (SELECT PpnId
              FROM $this->table WHERE PenerimaanInvoiceId='$id') b ON a.PpnId = b.PpnId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function pphSelected($id = NULL){
      $sql = "SELECT a.PphId, a.PphName,a.PphValue, CASE WHEN (b.PphId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstpphtagihan a LEFT JOIN (SELECT PphId
              FROM $this->table WHERE PenerimaanInvoiceId='$id') b ON a.PphId = b.PphId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function senderSelected($id = NULL){
      $sql = "SELECT a.SenderId, a.SenderName, CASE WHEN (b.SenderId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstsender a LEFT JOIN (SELECT SenderId
              FROM trnpenerimaaninvoice WHERE PenerimaanInvoiceId='$id') b ON a.SenderId = b.SenderId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function viewPaymentType($id = NULL){
      $sql = "SELECT a.PaymentTypeId, a.PaymentTypeName, a.PaymentTypeCode, CASE WHEN (b.PaymentTypeId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstpaymenttype a LEFT JOIN (SELECT PaymentTypeId
              FROM trnpenerimaaninvoice WHERE PenerimaanInvoiceId='$id') b ON a.PaymentTypeId = b.PaymentTypeId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function viewBillType($id = NULL){
      $sql = "SELECT a.BillTypeId, a.BillTypeName, a.BillTypeCode,
                CASE WHEN (b.BillTypeId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstbilltype a
              INNER JOIN (SELECT BillTypeId
                FROM trnpenerimaaninvoice WHERE PenerimaanInvoiceId='$id') b ON a.BillTypeId = b.BillTypeId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function viewBillTypeAll($id = NULL){
      $sql = "SELECT a.BillTypeId, a.BillTypeName, a.BillTypeCode,
                CASE WHEN (b.BillTypeId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstbilltype a
              LEFT OUTER JOIN (SELECT BillTypeId
                FROM trnpenerimaaninvoice WHERE PenerimaanInvoiceId='$id') b ON a.BillTypeId = b.BillTypeId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function viewSeqProyek($ProyekId = null, $id = NULL){
      $sql = "SELECT a.VendorId, b.VendorName, CASE WHEN (c.VendorId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM seqproyek a LEFT JOIN mstvendor b
              ON a.vendorid = b.vendorid
              LEFT JOIN (SELECT VendorId FROM trnpenerimaaninvoice WHERE PenerimaanInvoiceId='$id') c
              ON a.VendorId = c.VendorId
              WHERE a.ProyekId='$ProyekId' AND b.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function getSeqNoUrut($BillTypeId){
      $this->db->where('BillTypeId', $BillTypeId);
      return $this->db->get('seqnourut')->row();
    }

    function updateSeqNoUrut($BillTypeId, $LastNo){
      $sql = "SELECT BillTypeId
              FROM seqnourut WHERE BillTypeId='$BillTypeId'";
      $d   = $this->db->query($sql)->row();

      if(!$d){
        $this->insertSeqNoUrut($BillTypeId);
      }else{
        $this->db->where('BillTypeId', $BillTypeId);
        $this->db->update('seqnourut', array('LastNo' => $LastNo));
      }
    }

    function insertSeqNoUrut($BillTypeId){
      $d = $this->getNoUrut($BillTypeId);
      $data = array(
        'BillTypeId' => $BillTypeId,
        'LastNo' => str_pad($d->NoUrutMin+1, 4, '0', STR_PAD_LEFT)
      );
      $this->db->insert('seqnourut', $data);
    }

    function getNoUrut($BillTypeId){
      $sql = "SELECT b.BillTypeId, b.NoUrutMin, b.NoUrutMax, b.BillTypeName
              FROM mstbilltype b WHERE b.BillTypeId='$BillTypeId'";
      return $this->db->query($sql)->row();
    }

    function getProyekTypeCode($id = null){
      $sql = "SELECT b.ProyekTypeCode FROM trnproyek a LEFT JOIN mstbilltype b
              ON a.BillTypeId=b.BillTypeId
              WHERE a.ProyekId = '$id'";
      return $this->db->query($sql)->row();
    }

    function getDetailReport($id = null){
      $sql = "SELECT a.InvoiceNo, a.InvoiceDate, a.FakturNo, a.NpwpNo, a.RealCost, a.TotalValue, a.ReceivedDate, 
                     b.ProyekName, b.ProyekCode, c.VendorName, d.PpnValue, e.PphValue, f.name ,CONCAT(g.BillTypeCode,' ',a.BuktiNo) 
                     AS BuktiNo, h.SenderName, i.PaymentTypeName, i.PaymentTypeCode, a.AccountNumber, a.AccountByName, a.OtherSenderName, a.OtherSenderTelp
              FROM $this->table a
              LEFT JOIN trnproyek b ON a.ProyekId = b.ProyekId
              LEFT JOIN mstvendor c ON a.VendorId = c.VendorId
              LEFT JOIN mstppntagihan d ON a.PpnId = d.PpnId
              LEFT JOIN mstpphtagihan e ON a.PphId = e.PphId
              LEFT JOIN users f ON a.ReceivedId = f.id
              LEFT JOIN mstbilltype g ON a.BillTypeId = g.BillTypeId
              LEFT JOIN mstsender h ON a.SenderId = h.SenderId
              LEFT JOIN mstpaymenttype i ON a.PaymentTypeId=i.PaymentTypeId
              WHERE a.PenerimaanInvoiceId = '$id'";
      return $this->db->query($sql)->row();
    }

    function getGrpBillDocumentByBillTypeId($BillTypeId = null){
      $sql = "SELECT A.BillTypeId, B.BillTypeCode, B.BillTypeName, A.DocumentId, C.DocumentCode, C.DocumentName
              FROM grpbilldocument A
              JOIN mstbilltype B on A.BillTypeId = B.BillTypeId
              JOIN mstdocument C on A.DocumentId = C.DocumentId
              WHERE A.BillTypeId = '$BillTypeId'";

      return $this->db->query($sql)->result();
    }

    function getAllGrpBillDocument(){
      $sql = "SELECT A.BillTypeId, B.BillTypeCode, B.BillTypeName, A.DocumentId, C.DocumentCode, C.DocumentName
              FROM grpbilldocument A
              JOIN mstbilltype B on A.BillTypeId = B.BillTypeId
              JOIN mstdocument C on A.DocumentId = C.DocumentId";
      return $this->db->query($sql)->result();
    }

    function getSeqPenerimaanInvoiceDocumentById($PenerimaanInvoiceId){
      $sql = "SELECT A.PenerimaanInvoiceId, A.DocumentId, C.DocumentCode, C.DocumentName,
              	A.Path, A.UploadDate, A.UploadByUserId, D.name UploadByName
              FROM seqpenerimaaninvoicedocument A
              JOIN trnpenerimaaninvoice B on A.PenerimaanInvoiceId = B.PenerimaanInvoiceId
              JOIN mstdocument C on A.DocumentId = C.DocumentId
              LEFT OUTER JOIN users D on A.UploadByUserId = D.id
              WHERE A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
              ";
      return $this->db->query($sql)->result();
    }

    function getSeqPenerimaanInvoiceVerificationById($PenerimaanInvoiceId){
      $sql = "SELECT A.PenerimaanInvoiceId, A.DocumentId, C.DocumentCode, C.DocumentName,
              	A.JabatanId, D.JabatanCode, D.JabatanName, A.Status, A.VerificationDate, A.Note
              FROM seqpenerimaaninvoiceverification A
              JOIN trnpenerimaaninvoice B on A.PenerimaanInvoiceId = B.PenerimaanInvoiceId
              JOIN mstdocument C on A.DocumentId = C.DocumentId
              JOIN mstjabatan D on A.JabatanId = D.JabatanId
              WHERE A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
              ORDER BY A.PenerimaanInvoiceId, A.DocumentId, A.JabatanId
              ";
      return $this->db->query($sql)->result();
    }

    function getSeqPenerimaanInvoiceVerificationByPenerimaanInvoiceIdByDocumentId($PenerimaanInvoiceId, $DocumentId){
      $sql = "SELECT A.PenerimaanInvoiceId, A.DocumentId, C.DocumentCode, C.DocumentName,
              	A.JabatanId, D.JabatanCode, D.JabatanName, A.Status, A.VerificationDate, A.Note, A.UserVerification, E.name as NameVerification
              FROM seqpenerimaaninvoiceverification A
              JOIN trnpenerimaaninvoice B on A.PenerimaanInvoiceId = B.PenerimaanInvoiceId
              JOIN mstdocument C on A.DocumentId = C.DocumentId
              JOIN mstjabatan D on A.JabatanId = D.JabatanId
              LEFT JOIN users E on A.UserVerification = E.id
              WHERE A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
                AND A.DocumentId = '".$DocumentId."'
              ORDER BY A.PenerimaanInvoiceId, A.DocumentId, A.JabatanId
              ";
      return $this->db->query($sql)->result();
    }

    function getDocumentByPenerimaanInvoiceId($PenerimaanInvoiceId, $BillTypeId){
      $sql = "SELECT ".$BillTypeId." BillTypeId, A.DocumentId, B.DocumentCode, B.DocumentName, B.DocumentExample from seqpenerimaaninvoicedocument A
              JOIN mstdocument B on A.DocumentId = B.DocumentId
              WHERE A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
              ";
      return $this->db->query($sql)->result();
    }

    function getDocumentByPenerimaanInvoiceIdByDocumentId($PenerimaanInvoiceId, $DocumentId){
      $sql = "SELECT A.*, B.DocumentCode, B.DocumentName
				  FROM seqpenerimaaninvoicedocument A
          JOIN mstdocument B on A.DocumentId = B.DocumentId
				  where A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."' AND A.DocumentId = '".$DocumentId."'
              ";
      return $this->db->query($sql)->row();
    }

    function getVerificatorByPenerimaanInvoiceId($PenerimaanInvoiceId){
      $sql = "SELECT DISTINCT(A.JabatanId), B.JabatanCode, B.JabatanName
              FROM seqpenerimaaninvoicestatus A
              JOIN mstjabatan B on A.JabatanId = B.JabatanId
              WHERE A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
              ";
      return $this->db->query($sql)->result();
    }
    
    function getIsVerifStatusByPenerimaanInvoiceId($PenerimaanInvoiceId){
      $sql = "SELECT MIN(A.JabatanId) JabatanId
              FROM seqpenerimaaninvoicestatus A
              WHERE A.status = 0
                  AND A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
              ";
      return $this->db->query($sql)->result();
    }

    function getDocumentStatusByPenerimaanInvoiceId($PenerimaanInvoiceId){
      $Temp = $this-> getVerificatorByPenerimaanInvoiceId($PenerimaanInvoiceId);
      $tempSql = "";
      foreach ($Temp as $Val) {
        $tempSql .= " , (
                			SELECT Status FROM seqpenerimaaninvoiceverification
                			WHERE PenerimaanInvoiceId = A.PenerimaanInvoiceId AND
                				DocumentId = A.DocumentId AND JabatanId = '".$Val->JabatanId."'
                		) ".$Val->JabatanCode."
                  ";
      }

      $sql = "SELECT
              	A.PenerimaanInvoiceId, A.DocumentId, B.DocumentCode, B.DocumentName, A.Path, A.UploadDate, A.UploadByUserId, C.name UploadByName
              	".$tempSql."
                FROM seqpenerimaaninvoicedocument A
                LEFT OUTER JOIN mstdocument B on A.DocumentId = B.DocumentId
                LEFT OUTER JOIN users C on A.UploadByUserId = C.id
              WHERE A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
              ORDER BY A.DocumentId
              ";

      return $this->db->query($sql)->result();
    }

    function getDocumentStatusByPenerimaanInvoiceIdByDocumentId($PenerimaanInvoiceId, $DocumentId){
      $Temp = $this->getVerificatorByPenerimaanInvoiceId($PenerimaanInvoiceId);
      $tempSql = "";
      foreach ($Temp as $Val) {
        $tempSql .= " , (
                			SELECT Status FROM seqpenerimaaninvoiceverification
                			WHERE PenerimaanInvoiceId = '".$PenerimaanInvoiceId."' AND
                				DocumentId = '".$DocumentId."' AND JabatanId = '".$Val->JabatanId."'
                		) ".$Val->JabatanCode."
                  ";
        $tempSql .= " , (
                			SELECT VerificationDate FROM seqpenerimaaninvoiceverification
                			WHERE PenerimaanInvoiceId = '".$PenerimaanInvoiceId."' AND
              				DocumentId = '".$DocumentId."' AND JabatanId = '".$Val->JabatanId."'
                		) ".$Val->JabatanCode."_VerificationDate
                  ";
        $tempSql .= " , (
                			SELECT Note FROM seqpenerimaaninvoiceverification
                			WHERE PenerimaanInvoiceId = '".$PenerimaanInvoiceId."' AND
              				DocumentId = '".$DocumentId."' AND JabatanId = '".$Val->JabatanId."'
                		) ".$Val->JabatanCode."_Note
                  ";
      }

      $sql = "SELECT * FROM
              (
                SELECT
                	A.PenerimaanInvoiceId, A.DocumentId, B.DocumentCode, B.DocumentName, A.Path, A.UploadDate, A.UploadByUserId, C.name UploadByName
                	".$tempSql."
                  FROM seqpenerimaaninvoicedocument A
                  LEFT OUTER JOIN mstdocument B on A.DocumentId = B.DocumentId
                  LEFT OUTER JOIN users C on A.UploadByUserId = C.id
                WHERE A.PenerimaanInvoiceId = '".$PenerimaanInvoiceId."'
              ) tblCustome
              WHERE DocumentId = '".$DocumentId."'
              ";

      return $this->db->query($sql)->row();
    }

    function updateSeqPenerimaanInvoiceDocumentUpload($PenerimaanInvoiceId, $DocumentId, $Data){
      $this->db->where($this->id, $PenerimaanInvoiceId);
      $this->db->where("DocumentId", $DocumentId);
      $this->db->update('seqpenerimaaninvoicedocument', $Data);
    }


    function updateSeqPenerimaanInvoiceDocumentStatus($PenerimaanInvoiceId, $DocumentId, $JabatanId, $Data){
      $this->db->where($this->id, $PenerimaanInvoiceId);
      $this->db->where("DocumentId", $DocumentId);
      $this->db->where("JabatanId", $JabatanId);
      $this->db->update('seqpenerimaaninvoiceverification', $Data);
    }

    function updateSeqPenerimaanInvoiceDocumentStatusNull($PenerimaanInvoiceId, $DocumentId){
      $sql = "UPDATE
                seqpenerimaaninvoiceverification
              SET
                Status = 0,
                VerificationDate = NULL,
                Note = NULL
              WHERE PenerimaanInvoiceId = '".$PenerimaanInvoiceId."' AND DocumentId = '".$DocumentId."'
              ";

      $this->db->query($sql);
    }

    function email_to_verificator($PenerimaanInvoiceId)
    {
      $sql = "SELECT email FROM users WHERE JabatanId IN (SELECT MIN(JabatanId) FROM seqpenerimaaninvoicestatus WHERE Status = 0 AND PenerimaanInvoiceId = '".$PenerimaanInvoiceId."')";
      return $this->db->query($sql)->result_array();
    }


    function cekCompletedUpload($id){
      $sql = "SELECT PenerimaanInvoiceId, InvoiceNo,
                (SELECT count(0) FROM seqpenerimaaninvoicedocument WHERE PenerimaanInvoiceId = '$id') TotDocument,
                (SELECT count(0) FROM seqpenerimaaninvoicedocument WHERE (PenerimaanInvoiceId = '$id' AND path is not null ) OR ( PenerimaanInvoiceId = '$id' AND path <> '')) TotDocumentUpload
             FROM trnpenerimaaninvoice
             WHERE PenerimaanInvoiceId = '$id'";
      return $this->db->query($sql)->row();
    }
    
    function cekCompletedStatusInvoice($id){
      $sql = " select count(0) as TotStatus from seqpenerimaaninvoicestatus a WHERE a.status = 0 AND a.PenerimaanInvoiceId = '$id'";
      return $this->db->query($sql)->row();
    }

    function insertLampiran($data){
      $this->db->insert('seqlampiraninvoice', $data);
    }

    function deleteLampiran($path){
      $this->db->where('Path', $path);
      $this->db->delete('seqlampiraninvoice');
    }

    function getLampiran($PenerimaanInvoiceId){
      $this->db->where('PenerimaanInvoiceId', $PenerimaanInvoiceId);
      return $this->db->get('trnpenerimaaninvoice')->result();
    }
    
    function updateSsp($PenerimaanInvoiceId, $Data){
      $this->db->where($this->id, $PenerimaanInvoiceId);
      $this->db->update('trnpenerimaaninvoice', $Data);
    }
    
    function updateBuktiPotong($PenerimaanInvoiceId, $Data){
      $this->db->where($this->id, $PenerimaanInvoiceId);
      $this->db->update('trnpenerimaaninvoice', $Data);
    }
    
    function setPendingInvoiceStatus($id){
        $sql = "UPDATE seqpenerimaaninvoicestatus a 
                    set 
                        a.`Status`=0, a.StatusDate=NULL, a.Note=NULL, a.StatusByUserId=NULL, a.Ttd=NULL 
                WHERE a.PenerimaanInvoiceId = '".$id."' and a.`Status`=2";
        $this->db->query($sql);
    }
    
    function cekNewInvoice($id){
      $sql = " SELECT MAX(Status) Status from seqpenerimaaninvoicestatus a WHERE a.PenerimaanInvoiceId = '".$id."' ";
      return $this->db->query($sql)->row();
    }
}

/* End of file PenerimaanInvoice_model.php */
/* Location: ./application/models/PenerimaanInvoice_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-02-13 13:43:46 */
/* http://harviacode.com */
