<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_model extends CI_Model
{

    public $table = 'trnpayment';
    public $id = 'PaymentId';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select('a.CreatedByUserId, a.PaymentDate, a.PaymentId, b.InvoiceNo, c.VendorName');
        $this->db->join('trnpenerimaaninvoice b', 'b.PenerimaanInvoiceId=a.PenerimaanInvoiceId', 'LEFT');
        $this->db->join('mstvendor c', 'c.VendorId = b.VendorId', 'LEFT');
        $this->db->where(array('a.DeletedDate' => NULL));
        $this->db->order_by('a.'.$this->id, $this->order);
        return $this->db->get($this->table.' a')->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('a.PaymentId, a.PaymentDate, a.PaymentValue, b.InvoiceNo, b.VendorId, b.PenerimaanInvoiceId');
        $this->db->join('trnpenerimaaninvoice b', 'b.PenerimaanInvoiceId=a.PenerimaanInvoiceId', 'LEFT');
        $this->db->where('a.'.$this->id, $id);
        return $this->db->get($this->table.' a')->row();
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

    function vendorSelected($id = NULL){
      $sql = "SELECT a.VendorId, a.VendorCode, a.VendorName, CASE WHEN (b.VendorId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM mstvendor a LEFT JOIN (SELECT VendorId
              FROM trnpayment WHERE PaymentId='$id') b ON a.VendorId = b.VendorId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function invoiceSelected($id = NULL){
      $sql = "SELECT a.PenerimaanInvoiceId, a.InvoiceNo, CASE WHEN (b.PenerimaanInvoiceId IS NOT NULL) THEN \"selected = 'selected'\" ELSE 'null' END AS selected
              FROM trnpenerimaaninvoice a LEFT JOIN (SELECT PenerimaanInvoiceId
              FROM trnpayment WHERE PaymentId='$id') b ON a.PenerimaanInvoiceId = b.PenerimaanInvoiceId
              WHERE a.DeletedDate IS NULL";

      return $this->db->query($sql)->result();
    }

    function invoicePaymentSelected($VendorId = NULL){
      $sql = "SELECT a.PenerimaanInvoiceId, a.InvoiceNo, a.BuktiNo, b.BillTypeCode
                FROM trnpenerimaaninvoice a
                join mstbilltype b on a.BillTypeId = b.BillTypeId 
              WHERE a.DeletedDate IS NULL ";
              $sql.=($VendorId) ? "AND a.VendorId='$VendorId'" : "";

      return $this->db->query($sql)->result();
    }

    function getInvoice($VendorId = NULL, $PenerimaanInvoiceId = NULL){
        $sql = "SELECT a.InvoiceNo, a.TotalValue, a.ReceivedDate, b.VendorId, b.VendorName FROM trnpenerimaaninvoice a 
                JOIN mstvendor b on a.VendorId = b.VendorId WHERE ";
                $sql.=($VendorId) ? "a.VendorId='$VendorId' AND " : "";
                $sql.=($PenerimaanInvoiceId) ? "a.PenerimaanInvoiceId='$PenerimaanInvoiceId' AND" : "";
                $sql.=" a.DeletedDate IS NULL";
        return $this->db->query($sql)->result();
    }

    function getPembayaran($VendorId = NULL, $PenerimaanInvoiceId = NULL, $From = NULL, $To = NULL){
        $sql = "SELECT b.InvoiceNo, a.PaymentDate, a.PaymentValue, a.PaymentId FROM $this->table a
                LEFT JOIN trnpenerimaaninvoice b ON a.PenerimaanInvoiceId=b.PenerimaanInvoiceId
                WHERE ";
                $sql.=($VendorId) ? "a.VendorId = '$VendorId' AND " : "";
                $sql.=($From) ? "a.PaymentDate >= '$From' AND " : "";
                $sql.=($To) ? "a.PaymentDate <='$To' AND " : "";
                $sql.=($PenerimaanInvoiceId) ? "a.PenerimaanInvoiceId='$PenerimaanInvoiceId' AND" : "";
                $sql.=" a.DeletedDate IS NULL AND b.DeletedDate IS NULL";
        return $this->db->query($sql)->result();
    }

    function detailHutang($VendorId=NULL, $PenerimaanInvoiceId = NULL, $From = NULL, $To = NULL){
        $sql = "SELECT z.PenerimaanInvoiceId, z.PaymentValue, z.PaymentDate, a.InvoiceNo, a.FakturNo, a.BuktiNo, a.InvoiceDate, a.ReceivedDate,
                      a.RealCost, a.TotalValue, b.VendorName, c.PaymentTypeCode,
                      d.BillTypeCode, e.PpnName, f.PphName, e.PpnValue, f.PphValue, (z.PaymentValue - a.TotalValue) as Debt
                FROM trnpayment z LEFT JOIN trnpenerimaaninvoice a ON a.PenerimaanInvoiceId=z.PenerimaanInvoiceId
                      LEFT JOIN mstvendor b ON a.VendorId=b.VendorId
                      LEFT JOIN mstpaymenttype c ON a.PaymentTypeId=c.PaymentTypeId
                      LEFT JOIN mstbilltype d ON a.BillTypeId=d.BillTypeId
                      LEFT JOIN mstppntagihan e ON a.PpnId=e.PpnId
                      LEFT JOIN mstpphtagihan f ON a.PphId=f.PphId
                      WHERE ";
                $sql.=($VendorId) ? "a.VendorId = '$VendorId' AND " : "";
                $sql.=($From) ? "z.PaymentDate >= '$From' AND " : "";
                $sql.=($To) ? "z.PaymentDate <='$To' AND " : "";
                $sql.=($PenerimaanInvoiceId) ? "a.PenerimaanInvoiceId='$PenerimaanInvoiceId' AND" : "";
                $sql.=" z.DeletedDate IS NULL";

        return $this->db->query($sql)->result();
    }

    function debtList($VendorId = NULL, $PenerimaanInvoiceId = NULL, $PaymentStatus = NULL){
      $sql = "SELECT *, ((IFNULL(TotalPayment, 0))-TotalValue) AS SaldoHutang FROM
                    (
                      SELECT a.PenerimaanInvoiceId, a.VendorId, b.VendorName,
                        a.BillTypeId, c.BillTypeCode, c.BillTypeName, a.BuktiNo, a.InvoiceNo, a.InvoiceDate,
                        a.ReceivedDate, a.RealCost, a.TotalValue, a.DeletedDate,
                        (
                          SELECT SUM(Paymentvalue) FROM trnpayment WHERE DeletedDate IS NULL AND PenerimaanInvoiceId = a.PenerimaanInvoiceId
                        ) TotalPayment,
                        CASE
                          WHEN
                          (
                            SUM((SELECT SUM(Paymentvalue) FROM trnpayment WHERE DeletedDate IS NULL AND PenerimaanInvoiceId = a.PenerimaanInvoiceId)) = TotalValue
                          ) THEN 'Lunas'
                          WHEN
                          (
                            SUM((SELECT SUM(Paymentvalue) FROM trnpayment WHERE DeletedDate IS NULL AND PenerimaanInvoiceId = a.PenerimaanInvoiceId)) > TotalValue
                          ) THEN 'Lebih Bayar'
                          ELSE 'Belum Lunas'
                        END PaymentStatus
                      FROM 
                            (
                                SELECT PenerimaanInvoiceId, count(PenerimaanInvoiceId)
                                FROM
                                (
                                	select distinct(PenerimaanInvoiceId) FROM seqpenerimaaninvoicestatus WHERE Status = 1
                                	UNION ALL select distinct(PenerimaanInvoiceId) FROM seqpenerimaaninvoicestatus WHERE Status = 2
                                ) temp
                                GROUP BY PenerimaanInvoiceId
                                HAVING count(PenerimaanInvoiceId) = 1
                                ) w
                      JOIN trnpenerimaaninvoice a on w.PenerimaanInvoiceId = a.PenerimaanInvoiceId
                      JOIN mstvendor b ON a.VendorId = b.VendorId
                      JOIN mstbilltype c ON a.BillTypeId = c.BillTypeId
                      WHERE a.DeletedDate IS NULL
                      GROUP BY a.PenerimaanInvoiceId
                    ) xz WHERE
                    ";
                    $sql.=($VendorId) ? "xz.VendorId = '$VendorId' AND " : "";
                    $sql.=($PenerimaanInvoiceId) ? "xz.PenerimaanInvoiceId='$PenerimaanInvoiceId' AND" : "";
                    $sql.=($PaymentStatus) ? "xz.PaymentStatus = '$PaymentStatus' AND" : "";
                    $sql.=" xz.DeletedDate IS NULL ORDER BY ReceivedDate DESC";

        return $this->db->query($sql)->result();
    }

    function getTempImportPayment(){
      $sql = "SELECT B.InvoiceNo, B.BuktiNo, C.BillTypeCode, D.VendorName, 
                   E.ProyekName, A.PaymentValue, A.PaymentDate
              FROM `tempimportpayment` A 
                LEFT JOIN trnpenerimaaninvoice B ON A.PenerimaanInvoiceId=B.PenerimaanInvoiceId
                LEFT JOIN mstbilltype C ON C.BillTypeId=B.BillTypeId
                LEFT JOIN mstvendor D ON D.VendorId=A.VendorId
                LEFT JOIN trnproyek E ON E.ProyekId=B.ProyekId";
      return $this->db->query($sql)->result();
    }    

    function insertTempImportPayment($data){
      $this->db->insert('tempimportpayment', $data);
    }

    function truncateTempImportPayment(){
      $this->db->truncate('tempimportpayment');
    }

    function getInvoiceByNoBukti($BillTypeCode, $BuktiNo){
      $sql = "SELECT A.PenerimaanInvoiceId, A.VendorId
                    FROM trnpenerimaaninvoice A JOIN mstbilltype B ON A.BillTypeId=B.BillTypeId
              WHERE B.BillTypeCode='$BillTypeCode' AND A.BuktiNo='$BuktiNo'";
      return $this->db->query($sql)->row();
    }

    function validateTempPayment(){
      $sql = "INSERT INTO $this->table (PaymentId, PenerimaanInvoiceId, VendorId, PaymentDate, PaymentValue) 
              SELECT PaymentId, PenerimaanInvoiceId, VendorId, PaymentDate, PaymentValue FROM tempimportpayment";
      return $this->db->query($sql);
    }

    function searchInvoice($keyword = NULL){
      $sql = "SELECT a.PenerimaanInvoiceId, a.InvoiceNo, a.InvoiceDate, a.TotalValue, c.VendorName, 
                     CONCAT(d.BillTypeCode, a.BuktiNo) AS BuktiNo
            FROM trnpenerimaaninvoice a
            JOIN mstvendor c ON a.VendorId=c.VendorId
            JOIN mstbilltype d ON a.BillTypeId=d.BillTypeId
            WHERE 
              (CONCAT(d.BillTypeCode, a.BuktiNo, a.InvoiceNo) = '$keyword') AND (a.DeletedDate IS NULL)";
      return $this->db->query($sql)->result();
    }

    function getDetailPembayaran($PenerimaanInvoiceId = NULL){
      $sql = "SELECT b.BuktiNo, b.InvoiceNo, b.InvoiceDate, a.PaymentDate, a.PaymentValue, b.TotalValue, c.VendorName
            FROM $this->table a
            LEFT JOIN trnpenerimaaninvoice b ON a.PenerimaanInvoiceId=b.PenerimaanInvoiceId
            LEFT JOIN mstvendor c ON a.VendorId=c.VendorId
            WHERE a.PenerimaanInvoiceId = '$PenerimaanInvoiceId' AND (a.DeletedDate IS NULL AND b.DeletedDate IS NULL)";
      return $this->db->query($sql)->result();
    }

    function getInvoiceById($PenerimaanInvoiceId = NULL){
      $sql = "SELECT a.PenerimaanInvoiceId, a.InvoiceNo, a.InvoiceDate, a.TotalValue, c.VendorName, 
                     CONCAT(d.BillTypeCode, a.BuktiNo) AS BuktiNo
            FROM trnpenerimaaninvoice a
            JOIN mstvendor c ON a.VendorId=c.VendorId
            JOIN mstbilltype d ON a.BillTypeId=d.BillTypeId
            WHERE 
              a.PenerimaanInvoiceId='$PenerimaanInvoiceId' AND (a.DeletedDate IS NULL)";
      return $this->db->query($sql)->result();
    }

}

/* End of file Payment_model.php */
/* Location: ./application/models/Payment_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-03-28 16:56:15 */
/* http://harviacode.com */
