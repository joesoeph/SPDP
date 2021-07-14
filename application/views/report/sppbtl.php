<style type="text/css">
  table {
    font: 'Calibri';
    font-size: 10px;
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

  #frame{
    border: 0.5px solid black;
    width: 1500px;
    height: 1000px;
  }

</style>
<div id="frame">
  <table border="0" width="80%" align="center">
    <tr>
      <td width="20%" height="80px">&nbsp;</td>
      <td width="60%" align="center"><img src="<?=base_url('assets/Logo-PP.png')?>" width="100px"></td>
      <td width="20%"></td>
    </tr>
    <tr>
      <td></td>
      <td align="center"><u><h2>SURAT PERMINTAAN PEMBELIAN BTL</h2></u></td>
      <td></td>
    </tr>  
    <tr>
      <td>&nbsp;</td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" align="right">No SPP : <?=$DataSpp->SppNo?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td></td>
      <td></td>
    </tr>
  </table>

  <table border="1" id="tbl-list" width="100%">
    <tr>
      <td align="center">NO</td>
      <td align="center">KODE BARANG</td>
      <td align="center">QUANTITY</td>
      <td align="center">SATUAN</td>
      <td align="center">JENIS BARANG</td>
      <td align="center">UKURAN DAN SPESIFIKASI</td>
      <td align="center">UNTUK PEKERJAAN</td>
    </tr>
    <?php 
    $no = 0;
    foreach ($DataRequest as $val) { 
      $no++;
    echo'
    <tr>
      <td align="center">'.$no.'</td>
      <td align="center">'.$val->ResourceCode.'</td>
      <td align="center">'.$val->Quantity.'</td>
      <td align="center">'.$val->Unit.'</td>
      <td>'.$val->Item.'</td>
      <td>'.$val->Spesification.'</td>
      <td>'.$val->WorkFor.'</td>
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
    ?>
  </table>

  <table border="0" width="100%">
    <tr>
      <td width="20%" height="50px">&nbsp;</td>
      <td width="50%"></td>
      <td width="30%"></td>
    </tr>
    <tr>
      <td valign="top">Barang dikirim ke</td>
      <td valign="top">: <?=$DataSpp->SendTo?></td>
      <td valign="top"></td>
    </tr> 
    <tr>
      <td valign="top">Rencana dipakai tanggal</td>
      <td valign="top">: <?=$DataSpp->UsedDate?></td>
      <td valign="top"></td>
    </tr> 
    <tr>
      <td valign="top"></td>
      <td valign="top"></td>
      <td valign="top"><?=date("d M Y")?></td>
    </tr> 
  </table>

  <table border="0" width="100%">
    <tr>
      <td width="30%" height="25px">&nbsp;</td>
      <td width="30%" height="25px">&nbsp;</td>
      <td width="10%" height="25px">&nbsp;</td>
      <td width="30%" height="25px">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" align="center"></td>
      <td valign="top" colspan="3" align="center">Menyetujui</td>
    </tr> 
    <tr>
      <td valign="top" align="center">Pemohon</td>
      <td valign="top" align="center"><?=$DataSpp->JabatanApproval1?></td>
      <td valign="top" align="center"></td>
      <td valign="top" align="center"><?=$DataSpp->JabatanApproval2?></td>
    </tr> 
    <tr>
      <td align="center" height="100px"></td>
      <td align="center">
        <?php 
        if(!$DataSpp->Approval1Ttd){
          if($DataSpp->TtdHard2 == null){
              echo "( Not Available )";
          }else{
              echo '<img src="'.base_url('upload/ttd/'.$DataSpp->TtdHard2).'" width="50px">';
          }
        }else{
            echo '<img src="'.$DataSpp->Approval1Ttd.'" width="100px">';
        }
        ?>
      </td>
      <td align="center" height="100px"></td>
      <td align="center">
        <?php 
        if(!$DataSpp->Approval2Ttd){
            echo "( Not Available )";
        }else{
            echo '<img src="'.$DataSpp->Approval2Ttd.'" width="100px">';
        }
        ?>
      </td>
    </tr> 
    <tr>
      <td align="center">( <?=$DataSpp->Applicant?> )</td>
      <td align="center">( <?=$DataSpp->Approval1?> )<?php if($DataVerifycator[0]['Ttd']) echo '&nbsp;<img src="'.$DataVerifycator[0]['Ttd'].'" width="45px">';?></td>
      <td></td>
      <td align="center">( <?=$DataSpp->Approval2?> )</td>
    </tr> 
  </table>
</div>
