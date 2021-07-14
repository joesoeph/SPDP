<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GlobalModel extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }
    
	function getDataByWhere($table, $where){
    $this->db->where($where);
    return $this->db->get($table)->row();
  }

  function globalUpdate($table, $where, $data){
    $this->db->where($where);
    return $this->db->update($table, $data);
  }

  function email_verificator($AgreementId){
    $sql = "SELECT email FROM users a JOIN seqagreementstatus b ON a.JabatanId=b.JabatanId WHERE b.AgreementId='$AgreementId'";
    return $this->db->query($sql)->result_array();
  }

  function agreementVerifycationStatus($SppId){
    $sql = "SELECT a.*, b.JabatanName, c.name FROM seqagreementstatus a 
              LEFT JOIN mstjabatan b ON b.JabatanId=a.JabatanId 
              LEFT JOIN users c ON c.id=a.StatusByUserId
            WHERE a.AgreementId='$SppId'";
    return $this->db->query($sql)->result_array();
  }

  function updateAgreementStatus($id, $JabatanId, $data){
      $this->db->where(['AgreementId' => $id, 'JabatanId' => $JabatanId]);
      return $this->db->update('seqagreementstatus', $data);
  }

  function getEmailById($id){
    $this->db->select('email');
    $this->db->where('id', $id);
    return $this->db->get('users')->row();
  }

  function getCodeProyek(){
    $sql = " Select ProyekCode FROM trnproyek limit 1";
    $value = $this->db->query($sql)->row();

    return $value->ProyekCode;
  }

  function JobManager($UserId, $JabatanId, $RoleId){
    
    //Penerimaan Invoice Pending Submit
    $sql = "
                SELECT 
                  'Penerimaan Invoice' as MenuJob
                  , 'Pending Submit Invoice (Untuk Verifikasi)' as TitleJob
                  , CASE WHEN (SUM(a.TotalValue) is NULL) THEN 0 ELSE SUM(a.TotalValue) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'PenerimaanInvoice' as LinkUrl 
                FROM
                    trnpenerimaaninvoice a                   
                WHERE a.LockDate IS NULL
                    AND a.CreatedByUserId = ".$UserId." 

    ";

    //Penerimaan Invoice Pending Verifikasi
    $sql .= "   UNION ALL
                SELECT 
                  'Penerimaan Invoice' as MenuJob
                  , 'Pending Verifikasi' as TitleJob
                  , CASE WHEN (SUM(b.TotalValue) is NULL) THEN 0 ELSE SUM(b.TotalValue) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'PenerimaanInvoice/PendingVerification' as LinkUrl 
                FROM
                    seqpenerimaaninvoicestatus a
                JOIN trnpenerimaaninvoice b on a.PenerimaanInvoiceId = b.PenerimaanInvoiceId                     
                WHERE b.LockDate IS NOT NULL
                    AND a.Status = 0 AND a.JabatanId = ".$JabatanId."

    ";

    //Penerimaan Invoice Reject
    $sql .= "   UNION ALL
                SELECT 
                  'Penerimaan Invoice' as MenuJob
                  , 'Invoice Tolak / Revisi' as TitleJob
                  , CASE WHEN (SUM(b.TotalValue) is NULL) THEN 0 ELSE SUM(b.TotalValue) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'PenerimaanInvoice/Reject' as LinkUrl 
                FROM
                  (SELECT DISTINCT(PenerimaanInvoiceId) FROM seqpenerimaaninvoicestatus WHERE Status = 2) a 
                JOIN trnpenerimaaninvoice b on a.PenerimaanInvoiceId = b.PenerimaanInvoiceId 
                WHERE 
                  b.LockByUserId = ".$UserId." OR b.CreatedByUserId = ".$UserId." 
    ";

    //SPP Pending Submit
    $sql .= "   UNION ALL
                SELECT 
                  'SPP' as MenuJob
                  , 'Pending Submit SPP (Untuk Verifikasi)' as TitleJob
                  , 0 as TotalAmount
                  , Count(0) as TotalCase
                  , 'Spp' as LinkUrl 
                FROM
                    trnspp a                   
                WHERE a.LockDate IS NULL
                    AND a.CreatedByUserId = ".$UserId." 

    ";

    //SPP Pending Verifikasi
    $sql .= "   UNION ALL
                SELECT 
                  'SPP' as MenuJob
                  , 'Pending Verifikasi / Approve' as TitleJob
                  , 0 as TotalAmount
                  , Count(0) as TotalCase
                  , 'SppPo' as LinkUrl 
                FROM
                    trnspp a
                LEFT OUTER JOIN seqagreementstatus b on a.SppId = b.AgreementId
                WHERE
                    (
                      (a.Approval1 = ".$UserId." AND a.Approval1Status = 0 AND a.LockDate IS NOT NULL) 
                      OR (a.Approval2 = ".$UserId." AND a.Approval2Status = 0 AND a.LockDate IS NOT NULL)
                      OR (b.Agreement = 'SPP' AND b.JabatanId = ".$JabatanId." AND b.Status = 0 AND a.LockDate IS NOT NULL )
                    )
                    AND
                    (
                      (
                        a.Approval1Status NOT IN (2, 3) AND a.Approval2Status NOT IN (2, 3) AND  b.Status NOT IN (2, 3)
                      ) 
                    )
                    
    ";

    //SPP Pending Revisi
    $sql .= "   UNION ALL
                SELECT 
                  'SPP' as MenuJob
                  , 'Pending Revisi SPP' as TitleJob
                  , 0 as TotalAmount
                  , Count(0) as TotalCase
                  , 'SppPo' as LinkUrl 
                FROM
                    trnspp a
                LEFT OUTER JOIN seqagreementstatus b on a.SppId = b.AgreementId
                WHERE
                    (
                        b.Agreement = 'SPP'
                        AND
                        (
                          (a.LockByUserId = ".$UserId." OR a.CreatedByUserId = ".$UserId.") AND (a.Approval1Status = 3 or a.Approval2Status = 3)
                        ) 
                    )
                    OR 
                    (
                      b.Agreement = 'SPP' 
                      AND 
                      (a.LockByUserId = ".$UserId." OR a.CreatedByUserId = ".$UserId.") AND b.Status = 3
                    ) 
    ";

    //PO Pending Submit
    $sql .= "   UNION ALL
                SELECT 
                  'PO' as MenuJob
                  , 'Pending Submit PO(Untuk Verifikasi)' as TitleJob
                  , CASE WHEN (SUM(a.TotalAmount) is NULL) THEN 0 ELSE SUM(a.TotalAmount) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'Po' as LinkUrl 
                FROM
                    trnpo a                   
                WHERE a.LockDate IS NULL
                    AND a.CreatedByUserId = ".$UserId." 

    ";

    //PO Pending Verifikasi
    $sql .= "   UNION ALL
                SELECT 
                  'PO' as MenuJob
                  , 'Pending Verifikasi / Approve' as TitleJob
                  , CASE WHEN (SUM(TotalAmount) is NULL) THEN 0 ELSE SUM(TotalAmount) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'Po' as LinkUrl 
                FROM
                  trnpo a
                LEFT OUTER JOIN seqagreementstatus b on a.PoId = b.AgreementId
                WHERE
                    (
                      (a.Approval1 = ".$UserId." AND a.Approval1Status = 0 AND a.LockDate IS NOT NULL) 
                      OR (a.Approval2 = ".$UserId." AND a.Approval2Status = 0 AND a.LockDate IS NOT NULL)
                      OR (b.Agreement = 'PO' AND b.JabatanId = ".$JabatanId." AND b.Status = 0 AND a.LockDate IS NOT NULL)
                    )
                    AND
                    (
                      (
                        a.Approval1Status NOT IN (2, 3) AND a.Approval2Status NOT IN (2, 3) AND  b.Status NOT IN (2, 3)
                      ) 
                    )
    ";

    //PO Pending Revisi
    $sql .= "   UNION ALL
                SELECT 
                  'PO' as MenuJob
                  , 'Pending Revisi PO' as TitleJob
                  , CASE WHEN (SUM(TotalAmount) is NULL) THEN 0 ELSE SUM(TotalAmount) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'Po' as LinkUrl 
                FROM
                    trnpo a
                LEFT OUTER JOIN seqagreementstatus b on a.PoId = b.AgreementId
                WHERE
                    (
                        (
                          (a.LockByUserId = ".$UserId." OR a.CreatedByUserId = ".$UserId.") AND (a.Approval1Status = 3 or a.Approval2Status = 3)
                        ) 
                    )
                    OR 
                    (
                      b.Agreement = 'PO'
                      AND
                      (a.LockByUserId = ".$UserId." OR a.CreatedByUserId = ".$UserId.") AND b.Status = 3
                    ) 
    ";

    //SPPBTL Pending Submit
    $sql .= "   UNION ALL
                SELECT 
                  'SPP BTL' as MenuJob
                  , 'Pending Submit SPP BTL (Untuk Verifikasi)' as TitleJob
                  , 0 as TotalAmount
                  , Count(0) as TotalCase
                  , 'SppBtl' as LinkUrl 
                FROM
                    trnsppbtl a                   
                WHERE a.LockDate IS NULL
                    AND a.CreatedByUserId = ".$UserId." 

    ";

    //SPPBTL Pending Verifikasi
    $sql .= "   UNION ALL
                SELECT 
                  'SPP BTL' as MenuJob
                  , 'Pending Verifikasi / Approve' as TitleJob
                  , 0 as TotalAmount
                  , Count(0) as TotalCase
                  , 'SppBtl' as LinkUrl 
                FROM
                  trnsppbtl a
                LEFT OUTER JOIN seqagreementstatus b on a.SppBtlId = b.AgreementId
                WHERE
                    (
                      (a.Approval1 = ".$UserId." AND a.Approval1Status = 0 AND a.LockDate IS NOT NULL) 
                      OR (a.Approval2 = ".$UserId." AND a.Approval2Status = 0 AND a.LockDate IS NOT NULL)
                      OR (b.Agreement = 'BTL' AND b.JabatanId = ".$JabatanId." AND b.Status = 0 AND a.LockDate IS NOT NULL)
                    )
                    AND
                    (
                      (
                        a.Approval1Status NOT IN (2, 3) AND a.Approval2Status NOT IN (2, 3) AND  b.Status NOT IN (2, 3)
                      ) 
                    )
    ";

    //SPPBTL Pending Revisi
    $sql .= "   UNION ALL
                SELECT 
                  'SPP BTL' as MenuJob
                  , 'Pending Revisi SPP BTL' as TitleJob
                  , 0 TotalAmount
                  , Count(0) as TotalCase
                  , 'SppBtl' as LinkUrl 
                FROM
                    trnsppbtl a
                LEFT OUTER JOIN seqagreementstatus b on a.SppBtlId = b.AgreementId
                WHERE
                    (
                        (
                          (a.LockByUserId = ".$UserId." OR a.CreatedByUserId = ".$UserId.") AND (a.Approval1Status = 3 or a.Approval2Status = 3)
                        ) 
                    )
                    OR 
                    (
                      b.Agreement = 'BTL'
                      AND
                      (a.LockByUserId = ".$UserId." OR a.CreatedByUserId = ".$UserId.") AND b.Status = 3
                    ) 
    ";

    //SPK Pending Submit
    $sql .= "   UNION ALL
                SELECT 
                  'SPK' as MenuJob
                  , 'Pending Submit SPK (Untuk Verifikasi)' as TitleJob
                  , CASE WHEN (SUM(a.TotalValue) is NULL) THEN 0 ELSE SUM(a.TotalValue) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'Spk' as LinkUrl 
                FROM
                    trnspk a                   
                WHERE a.LockDate IS NULL
                    AND a.CreatedByUserId = ".$UserId." 

    ";

    //SPK Pending Verifikasi
    $sql .= "   UNION ALL
                SELECT 
                  'SPK' as MenuJob
                  , 'Pending Verifikasi / Approve' as TitleJob
                  , CASE WHEN (SUM(TotalValue) is NULL) THEN 0 ELSE SUM(TotalValue) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'Spk' as LinkUrl 
                FROM
                    trnspk a
                LEFT OUTER JOIN seqagreementstatus b on a.SpkId = b.AgreementId
                WHERE
                    (
                      (a.Giver1 = '".$UserId."' AND a.Approval1Status = 0 AND a.LockDate IS NOT NULL) 
                      OR (a.Giver2 = '".$UserId."' AND a.Approval2Status = 0 AND a.LockDate IS NOT NULL)
                      OR (b.Agreement = 'SPK' AND b.JabatanId = ".$JabatanId." AND b.Status = 0 AND a.LockDate IS NOT NULL)
                    )
                    AND
                    (
                      (
                        a.Approval1Status NOT IN (2, 3) AND a.Approval2Status NOT IN (2, 3) AND  b.Status NOT IN (2, 3)
                      ) 
                    )
    ";

    //SPK Pending Revisi
    $sql .= "   UNION ALL
                SELECT 
                  'SPK' as MenuJob
                  , 'Pending Revisi SPK' as TitleJob
                  , CASE WHEN (SUM(a.TotalValue) is NULL) THEN 0 ELSE SUM(a.TotalValue) END as TotalAmount
                  , Count(0) as TotalCase
                  , 'Spk' as LinkUrl 
                FROM
                    trnspk a
                LEFT OUTER JOIN seqagreementstatus b on a.SpkId = b.AgreementId
                WHERE
                    (
                        (
                          (a.LockByUserId = ".$UserId." OR a.CreatedByUserId = ".$UserId.") AND (a.Approval1Status = 3 or a.Approval2Status = 3)
                        ) 
                    )
                    OR 
                    (
                      b.Agreement = 'SPK'
                      AND
                      (a.LockByUserId = ".$UserId." OR a.CreatedByUserId = ".$UserId.") AND b.Status = 3
                    )
    ";

     //echo "<pre>"; var_dump($sql); exit(); 
    return $this->db->query($sql)->result_array();
  }

}

/* End of file globalModel.php */
/* Location: ./application/models/globalModel.php */