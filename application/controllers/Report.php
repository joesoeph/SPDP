<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('pdf');
    $this->load->model(array('SppPo_model', 'SppBtl_model', 'Spk_model', 'Payment_model', 'Vendor_model'));
  }

  function index()
  {

  }

  public function spp($SppId)
  {
    global $title;

    $DataSpp = $this->SppPo_model->getDetailSpp($SppId);
    $DataRequest = $this->SppPo_model->getRequestSpp($SppId);
    foreach ($DataRequest as $val) {
        $ResourceCode[$val->Sort] = $val->ResourceCode;
        $Quantity[$val->Sort]     = $val->Quantity;
        $Unit[$val->Sort]         = $val->Unit;
        $Jb[$val->Sort]           = $val->Item;
        $Spesification[$val->Sort]= $val->Spesification;
        $WorkFor[$val->Sort]      = $val->WorkFor;
    }
    $CountData = count($DataRequest);
    $fpdf = new PDF('P', 'cm', 'A4');
    $title = 'Print SPP';
    $fpdf->SetTitle($title);
    $fpdf->AliasNbPages();
    $fpdf->AddPage();
    // $fpdf->SetTextColor(0, 0, 0);
    // $fpdf->setFont('Times', '', 10);
    // $fpdf->SetX(12);
    // $fpdf->Cell(8, 0.5, 'Lampiran', 'LRT', 0, 'R');
    // $fpdf->Ln();
    // $fpdf->SetX(12);
    // $fpdf->Cell(8, 0.5, 'No. '.$DataSpp->SppNo, 'LRB', 0, 'R');

    $fpdf->Rect(1, 2.2, 19, 25);

    $fpdf->Text(1.1, 3, "PT. PEMBANGUNAN PERUMAHAN (PERSERO)");
    $fpdf->Text(1.1, 3.5, "DVO");
    $fpdf->Text(1.1, 4, "CB");
    $fpdf->Text(1.1, 4.5, "PROYEK");

    $fpdf->Text(4.5, 3.5, ": ".$DataSpp->Dvo);
    $fpdf->Text(4.5, 4, ": ".$DataSpp->Cb);
    $fpdf->Text(4.5, 4.5, ": ".$DataSpp->ProyekName);

    $fpdf->setFont('Times', 'U', 11);
    $fpdf->Text(7.5, 5, "SURAT PERMINTAAN PEMBELIAN");
    $fpdf->setFont('Times', '', 10);
    $fpdf->Text(11.5, 6, "No SPP : ".$DataSpp->SppNo);

    $fpdf->SetY(7);
    $fpdf->Cell(1, 0.5, 'NO', 'LRT', 0, 'C');
    $fpdf->Cell(2.5, 0.5, 'KODE', 'LRT', 0, 'C');
    $fpdf->Cell(2, 0.5, 'QUANTITY', 'LRT', 0, 'C');
    $fpdf->Cell(1.5, 0.5, 'SATUAN', 'LRT', 0, 'C');
    $fpdf->Cell(4.5, 0.5, 'JENIS BARANG', 'LRT', 0, 'C');
    $fpdf->Cell(4.5, 0.5, 'UKURAN DAN', 'LRT', 0, 'C');
    $fpdf->Cell(3, 0.5, 'UNTUK', 'LRT', 0, 'C');

    $fpdf->SetY(7.5);
    $fpdf->Cell(1, 0.5, '', 'LRB', 0, 'C');
    $fpdf->Cell(2.5, 0.5, 'BARANG', 'LRB', 0, 'C');
    $fpdf->Cell(2, 0.5, '', 'LRB', 0, 'C');
    $fpdf->Cell(1.5, 0.5, '', 'LRB', 0, 'C');
    $fpdf->Cell(4.5, 0.5, '', 'LRB', 0, 'C');
    $fpdf->Cell(4.5, 0.5, 'SPESIFIKASI', 'LRB', 0, 'C');
    $fpdf->Cell(3, 0.5, 'PEKERJAAN', 'LRB', 0, 'C');

    $fpdf->SetY(8);

    for ($i=1; $i < 21; $i++) {
      $fpdf->Cell(1, 0.5, ($i <= $CountData ? $i : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(2.5, 0.5, ($i <= $CountData ? $ResourceCode[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(2, 0.5, ($i <= $CountData ? $Quantity[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(1.5, 0.5, ($i <= $CountData ? $Unit[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(4.5, 0.5, ($i <= $CountData ? $Jb[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(4.5, 0.5, ($i <= $CountData ? $Spesification[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(3, 0.5, ($i <= $CountData ? $WorkFor[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Ln();
    }

    $fpdf->Text(1, 19, "Barang dikirim ke");
    $fpdf->Text(1, 20, "Rencana dipakai tanggal");

    $fpdf->Text(5, 19, ": ".$DataSpp->SendTo);
    $fpdf->Text(5, 20, ": ".$DataSpp->UsedDate);

    $fpdf->Text(13, 21, ": ".$DataSpp->UsedDate);

    $fpdf->Text(3, 21.5, "Menyetujui");

    $fpdf->ln(4);
    $fpdf->Cell(7, 0.5, $DataSpp->JabatanApproval1, '', 0, 'C');
    $fpdf->Cell(5, 0.5, '', '', 0, 'C');
    $fpdf->Cell(7, 0.5, $DataSpp->JabatanApproval2, '', 0, 'C');
    $fpdf->ln(2);
    
    if ($DataSpp->Approval1Status == 1){
        if($DataSpp->TtdHard1 == null){
            $fpdf->Cell(7, 0.5, '( Not Available )', '', 0, 'C');
        }else{
            $fpdf->Cell(7, 0.5, '', $fpdf->Image(base_url('upload/ttd/'.$DataSpp->TtdHard1),3.4,23.5,0,1.5), 0, 'C');
        }
    } else {
        $fpdf->Cell(7, 0.5, 'N A', '', 0, 'C');
    }

    $fpdf->Cell(5, 0.5, '', '', 0, 'C');

    if ($DataSpp->Approval2Status == 1) {
        if($DataSpp->TtdHard2 == null){
            $fpdf->Cell(7, 0.5, '( Not Available )', '', 0, 'C');
        }else{
            $fpdf->Cell(7, 0.5, '', $fpdf->Image(base_url('upload/ttd/'.$DataSpp->TtdHard2),15.8,23.5,0,1.5), 0, 'C');
        }
    } else {
        $fpdf->Cell(7, 0.5, 'N A', '', 0, 'C');
    }

    $fpdf->ln(2);
    $fpdf->Cell(7, 0.5, "( ".$DataSpp->Approval1." )", '', 0, 'C');
    $fpdf->Cell(5, 0.5, '', '', 0, 'C');
    $fpdf->Cell(7, 0.5, "( ".$DataSpp->Approval2." )", '', 0, 'C');


    $fpdf->Output();

  }

  public function sppbtl($SppBtlId)
  {
    global $title;

    $DataSpp = $this->SppBtl_model->getDetailSppBtl($SppBtlId);
    $DataRequest = $this->SppBtl_model->getRequestSppBtl($SppBtlId);
    foreach ($DataRequest as $val) {
        $ResourceCode[$val->Sort] = $val->ResourceCode;
        $Quantity[$val->Sort]     = $val->Quantity;
        $Unit[$val->Sort]         = $val->Unit;
        $Jb[$val->Sort]           = $val->Item;
        $Spesification[$val->Sort]= $val->Spesification;
        $WorkFor[$val->Sort]      = $val->WorkFor;
    }
    $CountData = count($DataRequest);

    $fpdf = new PDF('P', 'cm', 'A4');
    $title = 'Print SPP BTL';
    $fpdf->SetTitle($title);
    $fpdf->AliasNbPages();
    $fpdf->AddPage();
    // $fpdf->SetTextColor(0, 0, 0);
    // $fpdf->setFont('Times', '', 10);
    // $fpdf->SetX(12);
    // $fpdf->Cell(8, 0.5, 'Lampiran', 'LRT', 0, 'R');
    // $fpdf->Ln();
    // $fpdf->SetX(12);
    // $fpdf->Cell(8, 0.5, 'No. '.$DataSpp->SppNo, 'LRB', 0, 'R');

    $fpdf->Rect(1, 2.2, 19, 25);

    $fpdf->Text(1.1, 3, "PT. PEMBANGUNAN PERUMAHAN (PERSERO)");
    $fpdf->Text(1.1, 3.5, "DVO");
    $fpdf->Text(1.1, 4, "CB");
    $fpdf->Text(1.1, 4.5, "PROYEK");

    $fpdf->Text(4.5, 3.5, ": ".$DataSpp->Dvo);
    $fpdf->Text(4.5, 4, ": ".$DataSpp->Cb);
    $fpdf->Text(4.5, 4.5, ": ".$DataSpp->ProyekName);

    $fpdf->setFont('Times', 'U', 11);
    $fpdf->Text(7, 5, "SURAT PERMINTAAN PEMBELIAN BTL");
    $fpdf->setFont('Times', '', 10);
    $fpdf->Text(12.5, 6, "No : ".$DataSpp->SppNo);

    $fpdf->SetY(7);
    $fpdf->Cell(1, 0.5, 'NO', 'LRT', 0, 'C');
    $fpdf->Cell(2.5, 0.5, 'KODE', 'LRT', 0, 'C');
    $fpdf->Cell(2, 0.5, 'QUANTITY', 'LRT', 0, 'C');
    $fpdf->Cell(1.5, 0.5, 'SATUAN', 'LRT', 0, 'C');
    $fpdf->Cell(4.5, 0.5, 'JENIS BARANG', 'LRT', 0, 'C');
    $fpdf->Cell(4.5, 0.5, 'UKURAN DAN', 'LRT', 0, 'C');
    $fpdf->Cell(3, 0.5, 'UNTUK', 'LRT', 0, 'C');

    $fpdf->SetY(7.5);
    $fpdf->Cell(1, 0.5, '', 'LRB', 0, 'C');
    $fpdf->Cell(2.5, 0.5, 'BARANG', 'LRB', 0, 'C');
    $fpdf->Cell(2, 0.5, '', 'LRB', 0, 'C');
    $fpdf->Cell(1.5, 0.5, '', 'LRB', 0, 'C');
    $fpdf->Cell(4.5, 0.5, '', 'LRB', 0, 'C');
    $fpdf->Cell(4.5, 0.5, 'SPESIFIKASI', 'LRB', 0, 'C');
    $fpdf->Cell(3, 0.5, 'PEKERJAAN', 'LRB', 0, 'C');

    $fpdf->SetY(8);

    for ($i=1; $i < 21; $i++) {
      $fpdf->Cell(1, 0.5, ($i <= $CountData ? $i : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(2.5, 0.5, ($i <= $CountData ? $ResourceCode[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(2, 0.5, ($i <= $CountData ? $Quantity[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(1.5, 0.5, ($i <= $CountData ? $Unit[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(4.5, 0.5, ($i <= $CountData ? $Jb[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(4.5, 0.5, ($i <= $CountData ? $Spesification[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Cell(3, 0.5, ($i <= $CountData ? $WorkFor[$i] : ""), 'LRTB', 0, 'C');
      $fpdf->Ln();
    }

    $fpdf->Text(1, 19, "Barang dikirim ke");
    $fpdf->Text(1, 20, "Rencana dipakai tanggal");

    $fpdf->Text(5, 19, ": ".$DataSpp->SendTo);
    $fpdf->Text(5, 20, ": ".$DataSpp->UsedDate);

    $fpdf->Text(13, 21, date(("d F Y")));

    $fpdf->Text(3, 21.5, "Menyetujui");

    $fpdf->ln(4);
    $fpdf->Cell(7, 0.5, $DataSpp->JabatanApproval1, '', 0, 'C');
    $fpdf->Cell(5, 0.5, '', '', 0, 'C');
    $fpdf->Cell(7, 0.5, $DataSpp->JabatanApproval2, '', 0, 'C');
    $fpdf->ln(2);
    
    if ($DataSpp->Approval1Status == 1){
        if($DataSpp->TtdHard1 == null){
            $fpdf->Cell(7, 0.5, '( Not Available )', '', 0, 'C');
        }else{
            $fpdf->Cell(7, 0.5, '', $fpdf->Image(base_url('upload/ttd/'.$DataSpp->TtdHard1),3.4,23.5,0,1.5), 0, 'C');
        }
    } else {
        $fpdf->Cell(7, 0.5, 'N A', '', 0, 'C');
    }

    $fpdf->Cell(5, 0.5, '', '', 0, 'C');

    if ($DataSpp->Approval2Status == 1) {
        if($DataSpp->TtdHard2 == null){
            $fpdf->Cell(7, 0.5, '( Not Available )', '', 0, 'C');
        }else{
            $fpdf->Cell(7, 0.5, '', $fpdf->Image(base_url('upload/ttd/'.$DataSpp->TtdHard2),15.8,23.5,0,1.5), 0, 'C');
        }
    } else {
        $fpdf->Cell(7, 0.5, 'N A', '', 0, 'C');
    }

    $fpdf->ln(2);
    $fpdf->Cell(7, 0.5, "( ".$DataSpp->Approval1." )", '', 0, 'C');
    $fpdf->Cell(5, 0.5, '', '', 0, 'C');
    $fpdf->Cell(7, 0.5, "( ".$DataSpp->Approval2." )", '', 0, 'C');


    $fpdf->Output();

  }

  function checklist()
  {
    global $title;
    $fpdf = new PDF('L', 'cm', 'A4');
    $title = 'Penerimaan Tagihan';
    $fpdf->SetTitle($title);
    $fpdf->AliasNbPages();
    $fpdf->AddPage();
    $fpdf->Ln();
    $fpdf->SetTextColor(0, 0, 0);
    $fpdf->setFont('Arial', 'B', 12);
    $fpdf->SetX(1);
    $fpdf->SetY(1);
    $fpdf->Text(9, 1, 'CHECKLIST TAGIHAN SUBKONTRAKTOR');
    $fpdf->Text(11.5, 1.5, 'REGULER/SKBDN');

    $fpdf->setFont('Arial', 'B', 10);
    $fpdf->SetY(2);
    $fpdf->Cell(4, 1, 'NAMA PROYEK', 'LTB', 0, '');
    $fpdf->Cell(12, 1, ': ', 'RTB', 0, '');

    $fpdf->SetY(2);
    $fpdf->SetX(17.5);
    $fpdf->Cell(3, 1, 'KODE PROYEK', 'LRTB', 0, 'C');
    $fpdf->Cell(3, 1, 'NO. BUKTI', 'LRTB', 0, 'C');
    $fpdf->SetY(3);
    $fpdf->SetX(17.5);
    $fpdf->Cell(3, 1.3, '', 'LRTB', 0, 'C');
    $fpdf->Cell(3, 1.3, '', 'LRTB', 0, 'C');

    $fpdf->SetY(3.3);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NAMA VENDOR', 'LTB', 0, '');
    $fpdf->Cell(12, 1, ': ', 'RTB', 0, '');

    $fpdf->SetY(4.6);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NO INVOICE', 'LTB', 0, '');
    $fpdf->Cell(12, 1, ': ', 'RTB', 0, '');

    $fpdf->SetY(5.9);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'TGL INVOICE', 'LTB', 0, '');
    $fpdf->Cell(12, 1, ': ', 'RTB', 0, '');

    $fpdf->SetY(7.2);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NO FAKTUR PAJAK', 'LTB', 0, '');
    $fpdf->Cell(12, 1, ': ', 'RTB', 0, '');

    $fpdf->SetY(8.5);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'NO NPWP', 'LTB', 0, '');
    $fpdf->Cell(12, 1, ': ', 'RTB', 0, '');

    $fpdf->SetY(9.8);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'TIPE PEMBAYARAN', 'LTB', 0, '');
    $fpdf->Cell(12, 1, ': () ', 'RTB', 0, '');

    $fpdf->setFont('Arial', 'B', 9);
    $fpdf->SetY(11.3);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, 'REAL COST', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, 'PPN %', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, 'PPH %', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, 'NILAI REAL COST + PPN', 'LRTB', 0, 'C');

    $fpdf->SetY(12.3);
    $fpdf->SetX(1);
    $fpdf->Cell(4, 1, '', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, '', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, '', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 1, '', 'LRTB', 0, 'C');

    $fpdf->setFont('Arial', 'BU', 9, 'button');
    $fpdf->Text(17.5, 5, 'CHECKLIST KELENGKAPAN BERKAS');

    $fpdf->setFont('Arial', 'B', 9, 'button');
    $fpdf->SetY(5.6);
    $fpdf->SetX(17.5);
    $fpdf->Cell(0.5, 0.5, '', 'LRTB', 0, '');
    $fpdf->Text(18.2, 6, 'KWITANSI / INVOICE');

    $fpdf->SetY(6.6);
    $fpdf->SetX(17.5);
    $fpdf->Cell(0.5, 0.5, '', 'LRTB', 0, '');
    $fpdf->Text(18.2, 7, 'BAP SUBKONT');

    $fpdf->SetY(7.6);
    $fpdf->SetX(17.5);
    $fpdf->Cell(0.5, 0.5, '', 'LRTB', 0, '');
    $fpdf->Text(18.2, 8, 'BAL / LKP');

    $fpdf->SetY(8.6);
    $fpdf->SetX(17.5);
    $fpdf->Cell(0.5, 0.5, '', 'LRTB', 0, '');
    $fpdf->Text(18.2, 9, 'LPS');

    $fpdf->SetY(9.6);
    $fpdf->SetX(17.5);
    $fpdf->Cell(0.5, 0.5, '', 'LRTB', 0, '');
    $fpdf->Text(18.2, 10, 'KONTRAK SPB');

    $fpdf->SetY(10.6);
    $fpdf->SetX(17.5);
    $fpdf->Cell(0.5, 0.5, '', 'LRTB', 0, '');
    $fpdf->Text(18.2, 11, 'FP, SPT PPN & LAMPIRAN');

    $fpdf->SetY(11.6);
    $fpdf->SetX(17.5);
    $fpdf->Cell(0.5, 0.5, '', 'LRTB', 0, '');
    $fpdf->Text(18.2, 12, 'JURNAL LPS & PPN');

    $fpdf->SetY(12.6);
    $fpdf->SetX(17.5);
    $fpdf->Cell(0.5, 0.5, '', 'LRTB', 0, '');
    $fpdf->Text(18.2, 13, 'DOKUMEN KE BANK & SWIFT');

    $fpdf->SetY(14);
    $fpdf->SetX(1);
    $fpdf->Cell(5, 0.7, 'TELAH DIVERIFIKASI', 'LRTB', 0, 'C');
    $fpdf->Cell(1, 0.7, 'TGL', 'LRTB', 0, 'C');
    $fpdf->Cell(3, 0.7, 'PARAF', 'LRTB', 0, 'C');
    $fpdf->Cell(1.5, 0.7, 'YES', 'LRTB', 0, 'C');
    $fpdf->Cell(1.5, 0.7, 'NO', 'LRTB', 0, 'C');
    $fpdf->Cell(4, 0.7, 'KETERANGAN', 'LRTB', 0, 'C');

    $fpdf->SetY(14.7);
    $fpdf->SetX(1);
    $fpdf->Cell(5, 1, 'POP', 'LRTB', 0, 'L');
    $fpdf->Cell(1, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(3, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(4, 1, '', 'LRTB', 0, 'L');

    $fpdf->SetY(15.7);
    $fpdf->SetX(1);
    $fpdf->Cell(5, 1, 'CM / SEM', 'LRTB', 0, 'L');
    $fpdf->Cell(1, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(3, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(4, 1, '', 'LRTB', 0, 'L');

    $fpdf->SetY(16.7);
    $fpdf->SetX(1);
    $fpdf->Cell(5, 1, 'AM', 'LRTB', 0, 'L');
    $fpdf->Cell(1, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(3, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(4, 1, '', 'LRTB', 0, 'L');

    $fpdf->SetY(17.7);
    $fpdf->SetX(1);
    $fpdf->Cell(5, 1, 'PM', 'LRTB', 0, 'L');
    $fpdf->Cell(1, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(3, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 1, '', 'LRTB', 0, 'L');
    $fpdf->Cell(4, 1, '', 'LRTB', 0, 'L');

    $fpdf->Output();
  }

  public function po($PoId)
  {
    global $title;

    $DataPo = $this->SppPo_model->getDetailPo($PoId);
    $DataRequest = $this->SppPo_model->getRequestPo($PoId);

    foreach ($DataRequest as $val) {
        $Quantity[$val->Sort]     = $val->Quantity;
        $Unit[$val->Sort]         = $val->Unit;
        $Jb[$val->Sort]           = $val->Item;
        $Spesification[$val->Sort]= $val->Spesification;
        $Price[$val->Sort]        = $val->Price;
        $Amount[$val->Sort]       = $val->Amount;
    }
    $CountData = count($DataRequest);

    $fpdf = new PDF('P', 'cm', 'A4');
    $title = 'Print PO';
    $fpdf->SetTitle($title);
    $fpdf->AliasNbPages();
    $fpdf->AddPage();
    $fpdf->SetTextColor(0, 0, 0);

    $fpdf->Rect(1, 1, 19, 28);

    $fpdf->Image(base_url('assets/Logo-PP.png'),1.2,2,-1100);
    $fpdf->setFont('Arial', 'B', 8);
    $fpdf->Text(6.5, 2, "PT. PEMBANGUNAN PERUMAHAN (PERSERO)");

    $fpdf->setFont('Arial', '', 8);
    $fpdf->Text(7, 3, "DIVISI");
    $fpdf->Text(7, 3.5, "PROYEK");
    $fpdf->Text(7, 4, "ALAMAT");

    $fpdf->Text(8.5, 3, ": ".$DataPo->Dvo);
    $fpdf->Text(8.5, 3.5, ": ".$DataPo->ProyekName);
    $fpdf->Text(8.5, 4, ": ".$DataPo->ProyekDescription);

    $fpdf->setFont('Arial', 'U', 8);
    $fpdf->Text(6, 5.2, "S U R A T  P E S A N A N");
    $fpdf->setFont('Arial', '', 7);
    $fpdf->Text(6.6, 5.6, "PURCHASE ORDER");

    $fpdf->Text(1.5, 6.5, "3. Kepada / To ".$DataPo->VendorName);

    $fpdf->Text(1.5, 7.3, "4. ");
    $fpdf->setFont('Arial', 'U', 8);
    $fpdf->Text(1.8, 7.3, "Alamat ".$DataPo->Address1);
    $fpdf->setFont('Arial', '', 8);
    $fpdf->Text(1.5, 7.7, "   Address");

    $fpdf->Text(1.5, 8.7, "5. ");
    $fpdf->setFont('Arial', 'U', 7);
    $fpdf->Text(1.8, 8.7, "Dikirim ke ".$DataPo->SendTo);
    $fpdf->setFont('Arial', '', 7);
    $fpdf->Text(1.5, 9.1, "   Deliver To");

    $fpdf->Text(1.5, 10.1, "6. Berdasarkan No SPP ".$DataPo->SppNo);


    $fpdf->Text(11, 6.5, "1. No PO ".$DataPo->PoNo);

    $fpdf->Text(11, 7.5, "2. Tanggal ".$DataPo->PoDate);

    $fpdf->Text(11, 8.5, "3. No. Kode Pemasok ".$DataPo->SuplierCode);
    $fpdf->Text(11, 8.9, "(Sesuai Daftar Induk Pemasok)");

    $fpdf->SetY(10.5);
    $fpdf->setFont('Arial', '', 7);
    $fpdf->Cell(1, 1, '7. No.', 'TR', 0, 'C');
    $fpdf->Cell(2.5, 0.5, '8. Banyaknya', 'TR', 0, 'C');
    $fpdf->Cell(1.5, 1, 'Sat.', 'LTR', 0, 'C');
    $fpdf->Cell(3, 1, '9. Uraian Barang', 'TR', 0, 'C');
    $fpdf->Cell(4, 1, '10. Spesifikasi Standart', 'RT', 0, 'C');
    $fpdf->Cell(3.5, 0.5, '11. Harga Satuan', 'TR', 0, 'C');
    $fpdf->Cell(3.5, 0.5, '12. Jumlah', 'TR', 0, 'C');

    $fpdf->SetY(11);
    $fpdf->Cell(1, 0.5, '', 'B', 0, 'C');
    $fpdf->Cell(2.5, 0.5, 'Quantity', 'LB', 0, 'C');
    $fpdf->Cell(1.5, 0.5, '', 'LB', 0, 'C');
    $fpdf->Cell(3, 0.5, '', 'LB', 0, 'C');
    $fpdf->Cell(4, 0.5, '', 'LB', 0, 'C');
    $fpdf->Cell(3.5, 0.5, 'Unit Price', 'LB', 0, 'C');
    $fpdf->Cell(3.5, 0.5, 'Amount', 'LB', 0, 'C');

    $fpdf->SetY(11.5);

    for ($i=1; $i < 18; $i++) {
      $fpdf->Cell(1, 0.5, ($i <= $CountData ? $i : ""), 'L', 0, 'C');
      $fpdf->Cell(2.5, 0.5, ($i <= $CountData ? $Quantity[$i] : ""), 'L', 0, 'C');
      $fpdf->Cell(1.5, 0.5, ($i <= $CountData ? $Unit[$i] : ""), 'L', 0, 'C');
      $fpdf->Cell(3, 0.5, ($i <= $CountData ? $Jb[$i] : ""), 'L', 0, 'C');
      $fpdf->Cell(4, 0.5, ($i <= $CountData ? $Spesification[$i] : ""), 'L', 0, 'C');
      $fpdf->Cell(3.5, 0.5, ($i <= $CountData ? $Price[$i] : ""), 'L', 0, 'R');
      $fpdf->Cell(3.5, 0.5, ($i <= $CountData ? $Amount[$i] : ""), 'L', 0, 'R');
      $fpdf->Ln();
    }

    $fpdf->SetY(19.7);
    $fpdf->Cell(1, 0.5, '', 'LRTB', 0, 'L');
    $fpdf->Cell(2.5, 0.5, '', 'LRTB', 0, 'L');
    $fpdf->Cell(1.5, 0.5, '', 'LRTB', 0, 'L');
    $fpdf->Cell(3, 0.5, '', 'LRTB', 0, 'L');
    $fpdf->Cell(4, 0.5, 'TOTAL', 'LRTB', 0, 'L');
    $fpdf->Cell(3.5, 0.5, '', 'LRTB', 0, 'L');
    $fpdf->Cell(3.5, 0.5, $DataPo->TotalAmount, 'LRTB', 0, 'R');

    $TotalAmount = str_replace(",", "", $DataPo->TotalAmount);

    $fpdf->SetY(20.2);
    $fpdf->setFont('Arial', 'BI', 7);
    $fpdf->Cell(19, 0.5, 'Terbilang : '.$this->terbilang($TotalAmount).' rupiah', 'LRTB', 0, 'L');

    $fpdf->setFont('Arial', 'I', 7);
    $fpdf->Text(1.3, 21, '* harga sudah termasuk PPh');

    $fpdf->SetY(20.2);
    $fpdf->setFont('Arial', '', 7);
    $fpdf->Cell(19, 4, '', 'LRTB', 0, 'L');

    $fpdf->Text(1.3, 22, '13 Lain-lain');

    $fpdf->Text(1.5, 22.5, 'a. Waktu Penyerahan Barang');
    $fpdf->Text(7, 22.5, ': '.$DataPo->ReceiveDate);
    $fpdf->Text(7, 22.5, ':');

    $fpdf->Text(1.5, 23, 'b. Cara Pembayaran');
    $fpdf->Text(7, 23, ': Reguler');
    $fpdf->Text(7, 23.5, ': Pembayaran reguler 90 hari setelah invoice diterima dengan lengkap dan benar');

    $fpdf->Text(1.5, 24, 'c. Syarat-syarat');
    $fpdf->Text(7, 24, ': Apabila barang yang datang tidak sesuai Spesifikasi akan ditolak dan dikembalikan');

    $fpdf->Text(2.5, 25, 'Yang Menerima Order');

    $fpdf->Text(13, 25, 'Yang Memberi Order');

    $fpdf->setFont('Arial', 'B', 7);
    $fpdf->Text(11, 25.4, 'PT. PEMBANGUNAN PERUMAHAN (PERSERO)');

    $fpdf->SetY(27);
    $fpdf->setFont('Arial', 'BU', 7);
    $fpdf->Cell(6, 0.3, $DataPo->VendorName, '', 0, 'C');
    $fpdf->Cell(6, 0.3, $DataPo->Approval1, '', 0, 'C');
    $fpdf->Cell(6, 0.3, $DataPo->Approval2, '', 0, 'C');

    $fpdf->Ln();
    $fpdf->setFont('Arial', '', 7);
    $fpdf->Cell(6, 0.3, 'Suplier', '', 0, 'C');
    $fpdf->Cell(6, 0.3, $DataPo->JabatanApproval1, '', 0, 'C');
    $fpdf->Cell(6, 0.3, $DataPo->JabatanApproval2, '', 0, 'C');


    $fpdf->Output();
  }

    function report_spk($SpkId = NULL)
    {
      global $title;

        $DataSpk = $this->Spk_model->getDetailSpk($SpkId);
        $DataRequest = $this->Spk_model->getSeqSpk($SpkId);
        foreach ($DataRequest as $val) {
            $WbsCode[$val->Sort] = $val->WbsCode;
            $Volume[$val->Sort]     = $val->Volume;
            $Unit[$val->Sort]         = $val->Unit;
            $Working[$val->Sort]           = $val->Working;
            $UnitPrice[$val->Sort]= $val->UnitPrice;
            $TotalAmount[$val->Sort]      = $val->TotalAmount;
        }
        $CountData = count($DataRequest);

        $fpdf = new PDF('P', 'cm', 'A4');
        $title = 'Surat Perintah Kerja';
        $fpdf->SetTitle($title);
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->Ln();
        $fpdf->setFont('Arial', '', 9);
        $fpdf->Text(1, 1, "PT. PP (Persero) Tbk");
        $fpdf->Image(base_url('assets/ppspk.png'), 1, 1.5, -150);
        $fpdf->Text(1, 3, "Nama Proyek ");
        $fpdf->Text(1, 3.5, "Kode Proyek ");
        $fpdf->setFont('Arial', 'B', 9);
        $fpdf->Text(4, 3, $DataSpk->ProyekName);
        $fpdf->Text(4, 3.5, $DataSpk->ProyekCode);
        $fpdf->Rect(1.3, 4, 6, 1.3);
        $fpdf->setFont('Arial', 'BU', 9);
        $fpdf->Text(2.4, 4.5, "SURAT PERINTAH KERJA");
        $fpdf->setFont('Arial', 'B', 9);
        $fpdf->Text(4, 5, "(SPK)");

        $fpdf->setFont('Arial', '', 9);
        $fpdf->Text(1, 6, "Nama");
        $fpdf->Text(1, 6.5, "Alamat");
        $fpdf->Text(1, 7, "Jenis Pekerjaan");
        $fpdf->Text(1, 7.5, "Lokasi Pekerjaan");

        $fpdf->Text(4, 6, ": ".$DataSpk->Foreman);
        $fpdf->Text(4, 6.5, ": ".$DataSpk->Address);
        $fpdf->Text(4, 7, ": ".$DataSpk->WorkType);
        $fpdf->Text(4, 7.5, ": ".$DataSpk->WorkPlace);

        $fpdf->Text(13, 6, "Nomor SPK");
        $fpdf->Text(13, 6.5, "Tanggal");

        $fpdf->Text(16, 6, ": ".$DataSpk->SpkNo);
        $fpdf->Text(16, 6.5, ": ".date('d F Y', strtotime($DataSpk->DateSpk)));

        $fpdf->SetY(8);
        $fpdf->Cell(1, 0.5, 'No', 'LRTB', 0, 'C');
        $fpdf->Cell(3, 0.5, 'Kode WBS', 'LRTB', 0, 'C');
        $fpdf->Cell(7, 0.5, 'Pekerjaan', 'LRTB', 0, 'C');
        $fpdf->Cell(1, 0.5, 'Sat', 'LRTB', 0, 'C');
        $fpdf->Cell(1.5, 0.5, 'Volume', 'LRTB', 0, 'C');
        $fpdf->Cell(2.5, 0.5, 'Harga Satuan', 'LRTB', 0, 'C');
        $fpdf->Cell(3, 0.5, 'Total', 'LRTB', 0, 'C');

        $fpdf->SetY(8.5);

        for ($i=1; $i < 15; $i++) {
          $fpdf->Cell(1, 0.5, ($i <= $CountData ? $i : ""), 'L', 0, 'C');
          $fpdf->Cell(3, 0.5, ($i <= $CountData ? $WbsCode[$i] : ""), 'L', 0, 'C');
          $fpdf->Cell(7, 0.5, ($i <= $CountData ? $Working[$i] : ""), 'L', 0, 'L');
          $fpdf->Cell(1, 0.5, ($i <= $CountData ? $Unit[$i] : ""), 'L', 0, 'C');
          $fpdf->Cell(1.5, 0.5, ($i <= $CountData ? $Volume[$i] : ""), 'L', 0, 'C');
          $fpdf->Cell(2.5, 0.5, ($i <= $CountData ? $UnitPrice[$i] : ""), 'L', 0, 'R');
          $fpdf->Cell(3, 0.5, ($i <= $CountData ? $TotalAmount[$i] : ""), 'LR', 0, 'R');
          $fpdf->Ln();
        }

        $fpdf->SetY(15.5);
        $fpdf->Cell(1, 0.5, '', 'LTB', 0, 'C');
        $fpdf->Cell(3, 0.5, '', 'TB', 0, 'C');
        $fpdf->Cell(7, 0.5, '', 'TB', 0, 'C');
        $fpdf->Cell(1, 0.5, '', 'TB', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', 'TB', 0, 'C');
        $fpdf->Cell(2.5, 0.5, 'Jumlah', 'TB', 0, 'R');
        $fpdf->Cell(3, 0.5, $DataSpk->TotalValue, 'LRTB', 0, 'R');

        $TotalValue = str_replace(",", "", $DataSpk->TotalValue);

        $fpdf->SetY(16);
        $fpdf->Cell(1, 0.5, 'Terbilang', 'LTB', 0, 'L');
        $fpdf->Cell(2, 0.5, ':', 'TB', 0, 'R');
        $fpdf->Cell(8, 0.5, $this->terbilang($TotalValue).' rupiah', 'TB', 0, 'L');
        $fpdf->Cell(1, 0.5, '', 'TB', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', 'TB', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', 'TB', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'RTB', 0, 'C');

        $fpdf->SetY(16.05);
        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '', '', 0, 'C');
        $fpdf->Cell(7, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        // for ($i=1; $i < 11; $i++) {
        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '1.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Opnam progres sesuai volume dilapangan', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '2.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Lokasi harus selalu bersih dan rapih/housekeeping', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '3.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Bersedia kerja lembur', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '4.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Pekerjaan sesuai RKS, Shop Drawing dan bisa diterima oleh PT.PP (Persero) Tbk', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '5.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Harga Satuan tersebut sudah termasuk alat bantu/peralatan', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '6.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Helm, sepatu dan kelengkapan kerja (Safety) lainnya menjadi tanggung jawab Mandor', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '7.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Volume tidak mengikat', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '8.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Pembayaran dilakukan sesuai pekerjaan yang telah diselesaikan setiap 2 (dua) mingguan', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '9.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Retensi 5% dari nilai SPK dibayarkan setelah masa pemeliharaan selesai', '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '10.', '', 0, 'R');
        $fpdf->Cell(7, 0.5, 'Waktu Pelaksanaan Sejak : '.date('d-F-Y', strtotime($DataSpk->DateSpk)), '', 0, 'L');
        $fpdf->Cell(1, 0.5, '', '', 0, 'L');
        $fpdf->Cell(1.5, 0.5, '', '', 0, 'L');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();

        // }

        $fpdf->Cell(1, 0.5, '', 'LB', 0, 'L');
        $fpdf->Cell(3, 0.5, '', 'B', 0, 'C');
        $fpdf->Cell(7, 0.5, '', 'B', 0, 'C');
        $fpdf->Cell(1, 0.5, '', 'B', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', 'B', 0, 'C');
        $fpdf->Cell(2.5, 0.5, '', 'B', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'RB', 0, 'C');
        $fpdf->Ln();

        $fpdf->Cell(9, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(10, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();
        $fpdf->setFont('Arial', 'B', 9);
        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(5, 0.5, 'Pemborong', '', 0, 'C');
        $fpdf->Cell(5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, 'PT. PP (Persero) Tbk', '', 0, 'L');
        $fpdf->Cell(2.5, 0.5, '', '', 0, 'R');
        $fpdf->Cell(3, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();
        $fpdf->setFont('Arial', '', 9);
        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(3, 0.5, '', '', 0, 'L');
        $fpdf->Cell(7, 0.5, '', '', 0, 'C');
        $fpdf->Cell(1, 0.5, '', '', 0, 'C');
        $fpdf->Cell(3.5, 0.5, 'ADD-ON GRATI BLOCK 2 POWER PLANT PROJECT ', '', 0, 'C');
        $fpdf->Cell(3.5, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();
        $fpdf->Cell(1, 2, '', 'L', 0, 'L');
        $fpdf->Cell(3, 2, '', '', 0, 'L');
        $fpdf->Cell(7, 2, '', '', 0, 'C');
        $fpdf->Cell(1, 2, '', '', 0, 'C');
        $fpdf->Cell(3.5, 2, '', '', 0, 'C');
        $fpdf->Cell(3.5, 2, '', 'R', 0, 'C');
        $fpdf->Ln();
        $fpdf->setFont('Arial', 'BU', 8);
        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(5, 0.5, $DataSpk->Foreman, '', 0, 'C');
        $fpdf->Cell(3.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(4, 0.5, $DataSpk->Giver1, '', 0, 'C');
        $fpdf->Cell(4, 0.5, $DataSpk->Giver2, '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();
        $fpdf->setFont('Arial', '', 8);
        $fpdf->Cell(1, 0.5, '', 'L', 0, 'L');
        $fpdf->Cell(5, 0.5, 'Mandor', '', 0, 'C');
        $fpdf->Cell(3.5, 0.5, '', '', 0, 'C');
        $fpdf->Cell(4, 0.5, $DataSpk->JabatanGiver1, '', 0, 'C');
        $fpdf->Cell(4, 0.5, $DataSpk->JabatanGiver2, '', 0, 'C');
        $fpdf->Cell(1.5, 0.5, '', 'R', 0, 'C');
        $fpdf->Ln();
        $fpdf->Cell(1, 0.5, '', 'LB', 0, 'L');
        $fpdf->Cell(3, 0.5, '', 'B', 0, 'R');
        $fpdf->Cell(3.5, 0.5, '', 'B', 0, 'C');
        $fpdf->Cell(5.5, 0.5, '', 'B', 0, 'C');
        $fpdf->Cell(5.5, 0.5, '', 'B', 0, 'C');
        $fpdf->Cell(0.5, 0.5, '', 'RB', 0, 'C');

        $fpdf->Output();
    }

    function kekata($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x <12) {
                $temp = " ". $angka[$x];
        } else if ($x <20) {
                $temp = $this->kekata($x - 10). " belas";
        } else if ($x <100) {
                $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
        } else if ($x <200) {
                $temp = " seratus" . $this->kekata($x - 100);
        } else if ($x <1000) {
                $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
        } else if ($x <2000) {
                $temp = " seribu" . $this->kekata($x - 1000);
        } else if ($x <1000000) {
                $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
        } else if ($x <1000000000) {
                $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
        } else if ($x <1000000000000) {
                $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
        } else if ($x <1000000000000000) {
                $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
        }
                return $temp;
    }


    function terbilang($x, $style=4) {
        if($x<0) {
                $hasil = "minus ". trim($this->kekata($x));
        } else {
                $hasil = trim($this->kekata($x));
        }
        switch ($style) {
                case 1:
                        $hasil = strtoupper($hasil);
                        break;
                case 2:
                        $hasil = strtolower($hasil);
                        break;
                case 3:
                        $hasil = ucwords($hasil);
                        break;
                default:
                        $hasil = ucfirst($hasil);
                        break;
        }
        return $hasil;
    }

    // public function ReportByVendor($id)
    // {
    //   global $title;

    //   $DataInvoice = $this->Payment_model->getInvoice($id);
    //   $DataPembayaran = $this->Payment_model->getPembayaran($id);
    //   $vendor = $this->Vendor_model->get_by_id_obj($id);

    //   $fpdf = new PDF('P', 'cm', 'A4');
    //   $title = 'Hutang Vendor';
    //   $fpdf->SetTitle($title);
    //   $fpdf->AliasNbPages();
    //   $fpdf->AddPage();
    //   $fpdf->Ln();
    //   $fpdf->SetTextColor(0, 0, 0);
    //   $fpdf->setFont('Arial', 'B', 12);
    //   $fpdf->SetX(1);
    //   $fpdf->SetY(1);
    //   $fpdf->Cell(20, 0.7, 'SALDO HUTANG', '', 0, 'C');
    //   $fpdf->Ln();
    //   $fpdf->Cell(20, 0.7, 'PER TANGGAL '.date("Y-m-d"), '', 0, 'C');
    //   $fpdf->Ln();

    //   foreach ($vendor as $k) {
    //     $fpdf->Cell(20, 0.7, 'VENDOR: '.$k->VendorName, '', 0, 'C');
    //   }

    //   $fpdf->SetX(3);
    //   $fpdf->SetY(4);
    //   $fpdf->Cell(4, 1, 'INVOICE', 'LRTB', 0, 'C');
    //   $fpdf->Cell(4, 1, 'TOTAL VALUE', 'LRTB', 0, 'C');
    //   $fpdf->Cell(3, 1, 'TGL BAYAR', 'LRTB', 0, 'C');
    //   $fpdf->Cell(3, 1, 'INVOICE', 'LRTB', 0, 'C');
    //   $fpdf->Cell(5, 1, 'NILAI BAYAR', 'LRTB', 0, 'C');
    //   $fpdf->setFont('Arial', '', 11);
    //   $fpdf->Ln();

    //   $fpdf->SetY(5);
    //   $TotalAmount = 0;
    //   $CountInvoice = 0;
    //   foreach ($DataInvoice as $val) {
    //     $fpdf->Cell(4, 1, $val->InvoiceNo, 'LR', 0, 'C');
    //     $fpdf->Cell(4, 1, number_format($val->TotalValue), 'LR', 0, 'R');
    //     $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //     $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //     $fpdf->Cell(5, 1, '', 'LR', 0, 'C');
    //     $fpdf->ln();
    //     $TotalAmount+=$val->TotalValue;
    //     $CountInvoice++;
    //   }

    //   $fpdf->SetY(5);
    //   $TotalPayment = 0;
    //   foreach ($DataPembayaran as $val) {
    //     $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //     $fpdf->Cell(4, 1, '', 'LR', 0, 'R');
    //     $fpdf->Cell(3, 1, $val->PaymentDate, 'LR', 0, 'C');
    //     $fpdf->Cell(3, 1, $val->InvoiceNo, 'LR', 0, 'C');
    //     $fpdf->Cell(5, 1, number_format($val->PaymentValue), 'LR', 0, 'R');
    //     $fpdf->Ln();
    //     $TotalPayment+=$val->PaymentValue;
    //   }

    //   $a = count($DataInvoice);
    //   $b = count($DataPembayaran);

    //   if ($a > $b) {
    //     $fpdf->SetY(5);
    //     $c = ($a - $b) + 1;
    //     for ($i=0; $i <= $c ; $i++) {
    //       $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(5, 1, '', 'LR', 0, 'C');
    //       $fpdf->Ln();
    //     }
    //   } elseif ($a < $b) {
    //     $fpdf->SetY(5);
    //     $c = ($b - $a) + 1;
    //     for ($i=0; $i <= $c ; $i++) {
    //       $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(5, 1, '', 'LR', 0, 'C');
    //       $fpdf->Ln();
    //     }
    //   } elseif ($a == $b) {
    //     $fpdf->SetY(5);
    //     for ($i=0; $i <= $a ; $i++) {
    //       $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //       $fpdf->Cell(5, 1, '', 'LR', 0, 'C');
    //       $fpdf->Ln();
    //     }
    //   }

    //   // for ($i=1; $i < 5; $i++) {
    //   //   $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //   //   $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //   //   $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //   //   $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //   //   $fpdf->Cell(5, 1, '', 'LR', 0, 'C');
    //   //   $fpdf->Ln();
    //   // }
    //   $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //   $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //   $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //   $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //   $fpdf->Cell(5, 1, '', 'LR', 0, 'C');
    //   $fpdf->Ln();
    //   $fpdf->setFont('Arial', 'B', 11);
    //   $fpdf->Cell(4, 1, 'TOTAL TAGIHAN :', 'LTB', 0, 'L');
    //   $fpdf->Cell(5, 1, 'Rp. '.number_format($TotalAmount), 'TB', 0, 'L');
    //   $fpdf->Cell(3, 1, 'TOTAL PEMBAYARAN :', 'TB', 0, 'L');
    //   $fpdf->Cell(3, 1, '', 'TB', 0, 'C');
    //   $fpdf->Cell(4, 1, number_format($TotalPayment), 'RTB', 0, 'R');
    //   $fpdf->Ln();
    //   $fpdf->Cell(4, 1, 'JUMLAH INVOICE', 'L', 0, 'L');
    //   $fpdf->Cell(4.5, 1, '', '', 0, 'L');
    //   $fpdf->Cell(2.5, 1, '', '', 0, 'L');
    //   $fpdf->Cell(3, 1, ':', '', 0, 'C');
    //   $fpdf->Cell(5, 1, $CountInvoice, 'R', 0, 'R');
    //   $fpdf->Ln();
    //   $fpdf->Cell(4, 1, 'SALDO HUTANG', 'LB', 0, 'L');
    //   $fpdf->Cell(4.5, 1, '', 'B', 0, 'L');
    //   $fpdf->Cell(2.5, 1, '', 'B', 0, 'L');
    //   $fpdf->Cell(3, 1, ':', 'B', 0, 'C');
    //   $fpdf->Cell(5, 1, number_format($TotalAmount-$TotalPayment), 'RB', 0, 'R');



    //   $fpdf->Output();
    // }

    // public function ReportByInvoice($id, $vendor)
    // {
    //   global $title;

    //   $DataInvoice = $this->Payment_model->getInvoice(NULL, $id);
    //   $DataPembayaran = $this->Payment_model->getPembayaran(NULL, $id);

    //   $fpdf = new PDF('P', 'cm', 'A4');
    //   $title = 'Hutang Vendor';
    //   $fpdf->SetTitle($title);
    //   $fpdf->AliasNbPages();
    //   $fpdf->AddPage();
    //   $fpdf->Ln();
    //   $fpdf->SetTextColor(0, 0, 0);
    //   $fpdf->setFont('Arial', 'B', 12);
    //   $fpdf->SetX(1);
    //   $fpdf->SetY(1);
    //   $fpdf->Cell(20, 0.7, 'SALDO HUTANG', '', 0, 'C');
    //   $fpdf->Ln();
    //   $fpdf->Cell(20, 0.7, 'PER TANGGAL '.date("Y-m-d"), '', 0, 'C');
    //   $fpdf->Ln();
    //   $fpdf->Cell(20, 0.7, 'VENDOR: '.urldecode($vendor), '', 0, 'C');

    //   $fpdf->SetX(3);
    //   $fpdf->SetY(4);
    //   $fpdf->Cell(4, 1, 'INVOICE', 'LRTB', 0, 'C');
    //   $fpdf->Cell(4, 1, 'TOTAL VALUE', 'LRTB', 0, 'C');
    //   $fpdf->Cell(3, 1, 'TGL BAYAR', 'LRTB', 0, 'C');
    //   $fpdf->Cell(3, 1, 'INVOICE', 'LRTB', 0, 'C');
    //   $fpdf->Cell(5, 1, 'NILAI BAYAR', 'LRTB', 0, 'C');
    //   $fpdf->setFont('Arial', '', 11);
    //   $fpdf->Ln();

    //   $fpdf->SetY(5);
    //   $TotalAmount = 0;
    //   $CountInvoice = 0;
    //   foreach ($DataInvoice as $val) {
    //     $fpdf->Cell(4, 1, $val->InvoiceNo, 'LR', 0, 'C');
    //     $fpdf->Cell(4, 1, number_format($val->TotalValue), 'LR', 0, 'R');
    //     $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //     $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //     $fpdf->Cell(5, 1, '', 'LR', 0, 'C');
    //     $fpdf->ln();
    //     $TotalAmount+=$val->TotalValue;
    //     $CountInvoice++;
    //   }

    //   $fpdf->SetY(5);
    //   $TotalPayment = 0;
    //   foreach ($DataPembayaran as $val) {
    //     $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //     $fpdf->Cell(4, 1, '', 'LR', 0, 'R');
    //     $fpdf->Cell(3, 1, $val->PaymentDate, 'LR', 0, 'C');
    //     $fpdf->Cell(3, 1, $val->InvoiceNo, 'LR', 0, 'C');
    //     $fpdf->Cell(5, 1, number_format($val->PaymentValue), 'LR', 0, 'R');
    //     $fpdf->Ln();
    //     $TotalPayment+=$val->PaymentValue;
    //   }

    //   $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //   $fpdf->Cell(4, 1, '', 'LR', 0, 'C');
    //   $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //   $fpdf->Cell(3, 1, '', 'LR', 0, 'C');
    //   $fpdf->Cell(5, 1, '', 'LR', 0, 'C');
    //   $fpdf->Ln();

    //   $fpdf->setFont('Arial', 'B', 11);
    //   $fpdf->Cell(4, 1, 'TOTAL TAGIHAN :', 'LTB', 0, 'L');
    //   $fpdf->Cell(5, 1, 'Rp. '.number_format($TotalAmount), 'TB', 0, 'L');
    //   $fpdf->Cell(3, 1, 'TOTAL PEMBAYARAN :', 'TB', 0, 'L');
    //   $fpdf->Cell(3, 1, '', 'TB', 0, 'C');
    //   $fpdf->Cell(4, 1, number_format($TotalPayment), 'RTB', 0, 'R');
    //   $fpdf->Ln();
    //   $fpdf->Cell(4, 1, 'JUMLAH INVOICE', 'L', 0, 'L');
    //   $fpdf->Cell(4.5, 1, '', '', 0, 'L');
    //   $fpdf->Cell(2.5, 1, '', '', 0, 'L');
    //   $fpdf->Cell(3, 1, ':', '', 0, 'C');
    //   $fpdf->Cell(5, 1, $CountInvoice, 'R', 0, 'R');
    //   $fpdf->Ln();
    //   $fpdf->Cell(4, 1, 'SALDO HUTANG', 'LB', 0, 'L');
    //   $fpdf->Cell(4.5, 1, '', 'B', 0, 'L');
    //   $fpdf->Cell(2.5, 1, '', 'B', 0, 'L');
    //   $fpdf->Cell(3, 1, ':', 'B', 0, 'C');
    //   $fpdf->Cell(5, 1, number_format($TotalAmount-$TotalPayment), 'RB', 0, 'R');



    //   $fpdf->Output();
    // }

}
