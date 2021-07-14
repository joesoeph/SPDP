<?php

    if($DataPo->Approval1Status != 1 && $DataPo->Approval2Status != 1)
    {
        echo "Not Available";
        exit();
    }

  function kekata($x) { 
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }
        return $temp;
  }


  function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
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

  if($DataPo->WithPpn){
    $DescriptionPrice = str_replace("Harga tidak termasuk PPN", "Harga termasuk PPN", $DataPo->DescriptionPrice);
  }else{
    $DescriptionPrice = $DataPo->DescriptionPrice;
  }
?>
<style type="text/css">
  table {
    font: 'Calibri';
    font-size: 8px;
  }

  #tbl-list{
    border-collapse: collapse;
    border: 0.5px solid black;
  }
  #tbl-list td{
    border: 0.5px solid black;
    padding: 5px 5px 5px 5px;
  }
  tr.noBorder td {
    border: 0;
  }
  #tbl-list tr{
    height: 10px;
  }

  #frame{
    border: 0.5px solid black;
    width: 1500px;
    height: 1000px;
  }

</style>
<div id="frame">
  <table border="0" width="100%" align="center">
    <tr>
      <td width="100%" height="10px" colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td rowspan="4" width="20%" style="padding-left: 10px;">
        <img src="<?=base_url('assets/Logo-PP.jpg')?>" width="100px">
      </td>
      <td align="center" colspan="4" width="60%"><h2>PT.PEMBANGUNAN PERUMAHAN (Persero)</h2></td>
      <td rowspan="4" width="20%"></td>
    </tr>  
    <tr>
      <td width="10%"></td>
      <td width="15%">DVO / CABANG</td>
      <td colspan="2">: EPC</td>
    </tr>
    <tr>
      <td></td>
      <td>PROYEK</td>
      <td colspan="2">: <?=$DataPo->ProyekName?></td>
    </tr>
    <tr>
      <td></td>
      <td>ALAMAT</td>
      <td colspan="2">: <?=$DataPo->ProyekDescription?></td>
    </tr>
    <tr>
      <td width="100%" height="15px" colspan="6" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" colspan="6" align="center"><h3><u>SURAT PESANAN</u></h3></td>
    </tr>
    <tr>
      <td width="100%" colspan="6" align="center"><i>PURCHASE ORDER (PO)</i></td>
    </tr>
    <tr>
      <td width="100%" height="15px" colspan="6" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%">3. Kepada / TO</td>
      <td width="30%" colspan="2">: <?=$DataPo->VendorName?></td>
      <td>1. Nomor</td>
      <td colspan="2">: <?=$DataPo->PoNo?></td>
    </tr>
    <tr>
      <td>4. Alamat</td>
      <td colspan="2">: <?=$DataPo->Address1?></td>
      <td>2. Tanggal</td>
      <td colspan="2">: <?=date("d M Y", strtotime($DataPo->PoDate))?></td>
    </tr>
    <tr>
      <td>5. Dikirim Ke</td>
      <td colspan="2">: <?=$DataPo->SendTo?></td>
      <td></td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td valign="top">6. Berdasarkan SPP No</td>
      <td colspan="2">
      <?php 
      foreach ($SeqSppPo as $val) {
        echo ": ".$val->SppNo."<br>";
      }
      ?>
      </td>
      <td></td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td width="100%" height="15px" colspan="6">&nbsp;</td>
    </tr>
  </table>

  <table border="1" id="tbl-list" width="100%">
    <tr bgcolor="#dbb6cc">
      <td align="center" width="4%">7. No</td>
      <td align="center" width="10%">8. Banyaknya Quantity</td>
      <td align="center" width="5%">Sat</td>
      <td align="center">9. Uraian Barang</td>
      <td align="center">10. Spesifikasi standard</td>
      <td align="center" width="15%">11. Harga Satuan <br> Unit price</td>
      <td align="center" width="15%">12. Jumlah Amount</td>
    </tr>
    <?php
    $no = 0;
    $Total = 0;
    foreach ($DataRequest as $val) { 
      $no++;
    echo'
    <tr>
      <td align="center">'.$no.'</td>
      <td align="center">'.$val->QuantityPo.'</td>
      <td align="center">'.$val->Unit.'</td>
      <td align="center">'.$val->Item.'</td>
      <td>'.$val->Spesification.'</td>
      <td align="right">'.number_format($val->Price, 2, '.', ',').'</td>
      <td align="right">'.number_format($val->Amount, 2, '.', ',').'</td>
    </tr>';
    $Amount = str_replace(",", "", $val->Amount);
    $Total+=$Amount;
    }

    $noEnd = $no + 1;
    while ($no < $noEnd) {
    $no++; 
    echo'
    <tr>
      <td>&nbsp;</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>';
    }
    
    echo '<tr>
              <td colspan="6" align="right"><b>NK - PPN</b></td>
              <td align="right">'.number_format($Total, 2, '.', ',').'</td>
            </tr>';
            
    $TotalAmount = str_replace(",", "", $DataPo->TotalAmount);
    
    if($DataPo->WithPpn){
      echo '<tr>
              <td colspan="6" align="right"><b>PPN 10%</b></td>
              <td align="right">'.number_format(($Total*10/100), 2, '.', ',').'</td>
            </tr>';
    }else{
      echo '<tr>
              <td colspan="6" align="right"><b>PPN 0%</b></td>
              <td align="right">0.00</td>
            </tr>';
    }
    ?>
    <tr>
      <td colspan="6" align="right"><b>NK + PPN</b></td>
      <td align="right"><?=$DataPo->TotalAmount?></td>
    </tr>
    <tr>
      <td colspan="7"><i><b>Terbilang : <?=terbilang($TotalAmount)?> rupiah</b></i></td>
    </tr>
  </table>

  <table border="0" width="100%">
    <tr>
      <td width="20%" height="15px">Keterangan :</td>
      <td width="50%"></td>
      <td width="30%"></td>
    </tr>
    <tr>
      <td valign="top">a. Waktu Penyerahan Barang</td>
      <td valign="top"><?=$DataPo->ReceiveDate?></td>
      <td valign="top"></td>
    </tr> 
    <tr>
      <td valign="top">b. Harga</td>
      <td valign="top"><?=$DescriptionPrice?></td>
      <td valign="top"></td>
    </tr> 
    <tr>
      <td valign="top">c. Cara Pembayaran</td>
      <td valign="top"><?=$DataPo->DescriptionTypePayment?></td>
      <td valign="top"></td>
    </tr> 
    <tr>
      <td valign="top">d. Syarat - syarat</td>
      <td valign="top"><?=$DataPo->DescriptionTerm?></td>
      <td valign="top"></td>
    </tr> 
    <tr>
      <td valign="top" colspan="3" style="border-top: 1px solid black;"></td>
    </tr> 
  </table>

  <table border="0" width="100%">
    <tr>
      <td width="30%" height="15px">&nbsp;</td>
      <td width="30%"></td>
      <td width="30%"></td>
    </tr>
    <tr>
      <td valign="top" align="center">Yang Menerima Order</td>
      <td valign="top" align="center" colspan="2">Yang Memberi Order</td>
    </tr> 
    <tr>
      <td valign="top" align="center"></td>
      <td valign="top" align="center" colspan="2"><b>PT. PEMBANGUNAN PERUMAHAN (PERSERO)</b></td>
    </tr> 
    <tr>
      <td align="center" height="60px"></td>
      <td align="center">
        
      </td>
      <td align="center">
        
      </td>
    </tr> 
    <tr>
      <td valign="top" align="center"><u><?=$DataPo->VendorName?></u></td>
      <td valign="top" align="center"><u><?=$DataPo->Approval1?></u></td>
      <td valign="top" align="center"><u><?=$DataPo->Approval2?></u></td>
    </tr> 
    <tr>
      <td valign="top" align="center">Suplier</td>
      <td valign="top" align="center"><?=$DataPo->JabatanApproval1?></td>
      <td valign="top" align="center"><?=$DataPo->JabatanApproval2?></td>
    </tr> 
  </table>
</div>