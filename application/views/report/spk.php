<?php
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
    width: 100%;
    height: 100%;
  }

</style>
  <table border="0" width="100%" align="center">
    <!-- <tr>
      <td width="100%" height="10px" colspan="4">&nbsp;</td>
    </tr> -->
    <tr>
      <td colspan="4">PT. PP (Persero) Tbk</td>
    </tr>
    <tr>
      <td colspan="4"><img src="<?=base_url('assets/ppspk.png')?>" width="100px"></td>
    </tr>
    <tr>
      <td width="100%" height="10px" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="10%">Nama Proyek</td>
      <td colspan="3">: <?=$DataSpk->ProyekName?></td>
    </tr>
    <tr>
      <td>Kode Proyek</td>
      <td colspan="3">: <?=$DataSpk->ProyekCode?></td>
    </tr>
    <tr>
      <td width="100%" height="10px" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <h3>
          <u>SURAT PERINTAH KERJA</u><br>
          (SPK)
        </h3>
      </td>
      <td colspan="2" align="center"> 
        <h2><?=$DataSpk->SpkNoUrut?></h2>
      </td>
    </tr>
    <tr>
      <td width="100%" height="10px" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>: <?=$DataSpk->Foreman?></td>
      <td>Nomor SPK</td>
      <td>: <?=$DataSpk->SpkNo?></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>: <?=$DataSpk->Address?></td>
      <td>Tanggal</td>
      <td>: <?=date("d/m/Y", strtotime($DataSpk->DateSpk))?></td>
    </tr>
    <tr>
      <td>Jenis Pekerjaan</td>
      <td>: <?=$DataSpk->WorkType?></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>Lokasi Pekerjaan</td>
      <td>: <?=$DataSpk->WorkPlace?></td>
      <td></td>
      <td></td>
    </tr>
    <!-- <tr>
      <td width="100%" height="10px" colspan="4">&nbsp;</td>
    </tr> -->
  </table>

<div id="frame">
  <table border="1" id="tbl-list" width="100%" align="center">
    <tr>
      <td align="center" width="4%">No</td>
      <td align="center" width="15%">Kode WBS</td>
      <td align="center" width="30%">Pekerjaan</td>
      <td align="center" width="5%">Sat</td>
      <td align="center" width="10%">Volume</td>
      <td align="center" width="15%">Harga Satuan</td>
      <td align="center" width="15%">Total</td>
    </tr>
    <?php
    $no = 0;
    foreach ($DataRequest as $val) { 
      $no++;
    echo'
    <tr>
      <td align="center">'.$no.'</td>
      <td align="center">'.$val->WbsCode.'</td>
      <td align="center">'.$val->Working.'</td>
      <td align="center">'.$val->Unit.'</td>
      <td>'.$val->Volume.'</td>
      <td align="right">'.number_format($val->UnitPrice).'</td>
      <td align="right">'.number_format($val->TotalAmount).'</td>
    </tr>';
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
    $TotalAmount = str_replace(",", "", $DataSpk->TotalValue);
    ?>
    <tr>
      <td colspan="6" align="right"><b>TOTAL</b></td>
      <td align="right"><?=number_format($DataSpk->TotalValue)?></td>
    </tr>
    <tr>
      <td colspan="7"><i><b>Terbilang : <?=terbilang($TotalAmount)?> rupiah</b></i></td>
    </tr>
  </table>

  <table border="0" width="100%" align="center">
    <tr>
      <td height="15px">Term of condition :</td>
    </tr>
    <tr>
      <td valign="top">
        <?=$DataSpk->Term?>
      </td>
    </tr>
    <tr>
      <td valign="top" style="border-top: 1px solid black;"></td>
    </tr> 
  </table>

  <table border="0" width="100%" align="center">
    <tr>
      <td width="30%" height="15px">&nbsp;</td>
      <td width="30%"></td>
      <td width="10%"></td>
      <td width="30%"></td>
    </tr>
    <tr>
      <td valign="top" align="center"></td>
      <td valign="top" align="center" colspan="3"><b>PT. PEMBANGUNAN PERUMAHAN (PERSERO)</b></td>
    </tr> 
    <tr>
      <td valign="top" align="center"></td>
      <td valign="top" align="center" colspan="3"><?=$DataSpk->ProyekName?></td>
    </tr>
    <tr>
      <td valign="top" align="center">Pemborong</td>
      <td valign="top" align="center"><?=$DataSpk->JabatanGiver1?></td>
      <td></td>
      <td valign="top" align="center"><?=$DataSpk->JabatanGiver2?></td>
    </tr> 
    <tr>
      <td align="center" height="60px"></td>
      <td align="center">
        <?php 
        if(!$DataSpk->Approval1Ttd){
          if($DataSpk->TtdHard2 == null){
              echo "( Not Available )";
          }else{
              echo '<img src="'.base_url('upload/ttd/'.$DataSpk->TtdHard2).'" width="100px">';
          }
        }else{
            echo '<img src="'.$DataSpk->Approval1Ttd.'" width="100px">';
        }
        ?>
      </td>
      <td align="center" height="100px"></td>
      <td align="center">
        <?php 
        if(!$DataSpk->Approval2Ttd){
            echo " ";
        }else{
            echo '<img src="'.$DataSpk->Approval2Ttd.'" width="100px">';
        }
        ?>
      </td> 
    </tr> 
    <tr>
      <td align="center"><u><?=$DataSpk->Foreman?></u></td>
      <td align="center"><u><?=$DataSpk->Giver1?></u><?php if($DataVerifycator[0]['Ttd']) echo '&nbsp;<img src="'.$DataVerifycator[0]['Ttd'].'" width="45px">';?></td>
      <td></td>
      <td align="center"><u><?=$DataSpk->Giver2?></u></td>
    </tr> 
  </table>
</div>