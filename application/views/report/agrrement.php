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
<HTML>
<HEAD>
<TITLE>bcl_242071600.htm</TITLE>
<STYLE type="text/css">

body {
	margin-top: 0px;margin-left: 0px;
}

#frame{
    border: 1px solid black;
    width: 1500px;
    height: 1000px;
  }

#page_1 {position:relative; overflow: hidden;margin: 0px;padding: 0px;border: none;width: 737px;}
#page_1 #id_1 {border:none;margin: 11px 0px 0px 18px;padding: 0px;border:none;width: 719px;overflow: hidden;}

#page_1 #id_3 {border:none;margin: 11px 0px 0px 30px;padding: 0px;border:none;width: 610px;overflow: hidden;}

#page_1 #p1dimg1 {position:absolute;top:0px;left:0px;z-index:-1;width:657px;height:990px;}
#page_1 #p1dimg1 #p1img1 {width:657px;height:990px;}




.dclr {clear:both;float:none;height:1px;margin:0px;padding:0px;overflow:hidden;}

.ft0{font: bold 9px 'Arial';line-height: 11px;}
.ft1{font: bold 8px 'Arial';line-height: 10px;}
.ft2{font: bold 8px 'Arial';line-height: 9px;}
.ft3{font: bold 7px 'Arial';line-height: 7px;}
.ft4{font: bold 9px 'Arial';text-decoration: underline;line-height: 11px;}
.ft5{font: 1px 'Arial';line-height: 9px;}
.ft6{font: 1px 'Arial';line-height: 1px;}
.ft7{font: bold 8px 'Arial';margin-left: 2px;line-height: 9px;}
.ft8{font: bold 7px 'Arial';margin-left: 2px;line-height: 10px;}
.ft9{font: bold 7px 'Arial';line-height: 10px;}
.ft10{font: bold 8px 'Arial';margin-left: 3px;line-height: 10px;}
.ft11{font: bold 6px 'Arial';line-height: 6px;}
.ft12{font: bold 8px 'Arial';margin-left: 4px;line-height: 10px;}
.ft13{font: bold 8px 'Arial';margin-left: 2px;line-height: 10px;}
.ft14{font: bold 8px 'Arial';text-decoration: underline;line-height: 10px;}
.ft15{font: bold 7px 'Arial';text-decoration: underline;line-height: 7px;}

.p0{text-align: left;padding-left: 212px;margin-top: 0px;margin-bottom: 0px;}
.p1{text-align: left;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p2{text-align: left;padding-left: 229px;margin-top: 10px;margin-bottom: 0px;}
.p3{text-align: left;padding-left: 252px;margin-top: 0px;margin-bottom: 0px;}
.p4{text-align: left;padding-left: 232px;margin-top: 10px;margin-bottom: 0px;}
.p5{text-align: right;padding-right: 1px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p6{text-align: left;padding-left: 2px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p7{text-align: left;padding-left: 11px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p8{text-align: right;padding-right: 67px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p9{text-align: right;padding-right: 70px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p10{text-align: left;padding-left: 17px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p11{text-align: right;padding-right: 222px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p12{text-align: left;padding-left: 19px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p13{text-align: left;padding-left: 1px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p14{text-align: left;padding-left: 15px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p15{text-align: left;padding-left: 146px;padding-right: 95px;margin-top: 0px;margin-bottom: 0px;}
.p16{text-align: left;padding-left: 146px;padding-right: 82px;margin-top: 2px;margin-bottom: 0px;}
.p17{text-align: left;padding-left: 16px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p18{text-align: left;padding-left: 12px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p19{text-align: left;padding-left: 62px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p20{text-align: left;padding-left: 13px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p21{text-align: left;padding-left: 6px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p22{text-align: left;padding-left: 3px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p23{text-align: right;padding-right: 22px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p24{text-align: left;padding-left: 60px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p25{text-align: center;padding-right: 3px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p26{text-align: center;padding-right: 26px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p27{text-align: right;padding-right: 36px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p28{text-align: right;padding-right: 4px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p29{text-align: left;padding-left: 8px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p30{text-align: right;padding-right: 9px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p31{text-align: right;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p32{text-align: left;padding-left: 12px;margin-top: 0px;margin-bottom: 0px;}
.p33{text-align: left;padding-left: 12px;margin-top: 0px;margin-bottom: 0px;text-indent: -12px;}
.p34{text-align: left;padding-left: 6px;padding-right: 29px;margin-top: 0px;margin-bottom: 0px;text-indent: -6px;}
.p35{text-align: left;padding-left: 6px;padding-right: 20px;margin-top: 1px;margin-bottom: 0px;}
.p36{text-align: left;padding-left: 6px;margin-top: 2px;margin-bottom: 0px;}
.p37{text-align: left;margin-top: 0px;margin-bottom: 0px;}
.p38{text-align: center;padding-right: 264px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p39{text-align: center;padding-right: 1px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p40{text-align: center;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p41{text-align: center;padding-right: 183px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p42{text-align: center;padding-right: 108px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p43{text-align: center;padding-right: 109px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}

.td0{padding: 0px;margin: 0px;width: 99px;vertical-align: bottom;}
.td1{padding: 0px;margin: 0px;width: 236px;vertical-align: bottom;}
.td2{padding: 0px;margin: 0px;width: 6px;vertical-align: bottom;}
.td3{padding: 0px;margin: 0px;width: 119px;vertical-align: bottom;}
.td4{padding: 0px;margin: 0px;width: 114px;vertical-align: bottom;}
.td5{padding: 0px;margin: 0px;width: 283px;vertical-align: bottom;}
.td6{padding: 0px;margin: 0px;width: 103px;vertical-align: bottom;}
.td7{padding: 0px;margin: 0px;width: 24px;vertical-align: bottom;}
.td8{padding: 0px;margin: 0px;width: 90px;vertical-align: bottom;}
.td9{padding: 0px;margin: 0px;width: 397px;vertical-align: bottom;}
.td10{padding: 0px;margin: 0px;width: 373px;vertical-align: bottom;}
.td11{padding: 0px;margin: 0px;width: 476px;vertical-align: bottom;}
.td12{padding: 0px;margin: 0px;width: 500px;vertical-align: bottom;}
.td13{padding: 0px;margin: 0px;width: 124px;vertical-align: bottom;}
.td14{padding: 0px;margin: 0px;width: 509px;vertical-align: bottom;}
.td15{padding: 0px;margin: 0px;width: 69px;vertical-align: bottom;}
.td16{padding: 0px;margin: 0px;width: 55px;vertical-align: bottom;}
.td17{padding: 0px;margin: 0px;width: 21px;vertical-align: bottom;}
.td18{padding: 0px;margin: 0px;width: 488px;vertical-align: bottom;}
.td19{padding: 0px;margin: 0px;width: 298px;vertical-align: bottom;}
.td20{padding: 0px;margin: 0px;width: 86px;vertical-align: bottom;}
.td21{padding: 0px;margin: 0px;width: 27px;vertical-align: bottom;}
.td22{padding: 0px;margin: 0px;width: 77px;vertical-align: bottom;}
.td23{padding: 0px;margin: 0px;width: 166px;vertical-align: bottom;}
.td24{padding: 0px;margin: 0px;width: 112px;vertical-align: bottom;}
.td25{padding: 0px;margin: 0px;width: 20px;vertical-align: bottom;}
.td26{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 20px;vertical-align: bottom;}
.td27{padding: 0px;margin: 0px;width: 106px;vertical-align: bottom;}
.td28{padding: 0px;margin: 0px;width: 360px;vertical-align: bottom;}
.td29{padding: 0px;margin: 0px;width: 172px;vertical-align: bottom;}
.td30{padding: 0px;margin: 0px;width: 247px;vertical-align: bottom;}
.td31{padding: 0px;margin: 0px;width: 257px;vertical-align: bottom;}
.td32{padding: 0px;margin: 0px;width: 67px;vertical-align: bottom;}

.tr0{height: 10px;}
.tr1{height: 9px;}
.tr2{height: 11px;}
.tr3{height: 20px;}
.tr4{height: 23px;}
.tr5{height: 12px;}
.tr6{height: 19px;}
.tr7{height: 29px;}
.tr8{height: 14px;}

.t0{width: 335px;margin-left: 0px;margin-top: 7px;font: bold 8px 'Arial';}
.t1{width: 625px;margin-left: 4px;margin-top: 9px;font: bold 8px 'Arial';}
.t2{width: 633px;margin-top: 7px;font: bold 8px 'Arial';}
.t3{width: 633px;margin-left: 0px;margin-top: 18px;font: bold 7px 'Arial';}

  #table-desc{
    border-collapse: collapse;
    border: 1px solid black;
  }
  #table-desc td{
    border: 1px solid black;
  }

</STYLE>
</HEAD>

<BODY>
<div id="frame">
<DIV id="page_1">
<DIV id="p1dimg1">

<DIV id="id_1">
<TABLE cellpadding=0 cellspacing=0  width="100%">
	<TR>
		<TD class="tr0 td0" colspan="3" align="center"><P class="p1 ft1"><P class="p0 ft0">PT. PEMBANGUNAN PERUMAHAN (PERSERO)</P></P></TD>
	</TR>
	<TR>
		<td rowspan="5" width="180px">
			<img src="<?=base_url('assets/Logo-PP.jpg')?>" alt="" width="100px">
		</td>
		<TD class="tr0 td0" colspan="2"></TD>
	</TR>
	<TR>
		<TD class="tr0 td0"><P class="p1 ft1">DIVISI (DIVISION)</P></TD>
		<TD class="tr0 td1"><P class="p1 ft1">: EPC</P></TD>
	</TR>
	<TR>
		<TD class="tr1 td0"><P class="p1 ft2">PROYEK (PROJECT)</P></TD>
		<TD class="tr1 td1"><P class="p1 ft2">: <?=$ProyekName;?></P></TD>
	</TR>
	<TR>
		<TD class="tr2 td0"><P class="p1 ft1">ALAMAT (ADDRESS)</P></TD>
		<TD class="tr2 td1"><P class="p1 ft3">: <?=$ProyekAddress;?></P></TD>
	</TR>
	<TR>
		<TD class="tr0 td0" colspan="2"></TD>
	</TR>
</TABLE>

<table cellpadding=0 cellspacing=0 width="100%">
	<TR>
		<TD class="tr0 td0" colspan="3" align="center">
			<P class="p2 ft4">SURAT PERJANJIAN <?=str_replace("NON NPWP", '', strtoupper($data->AgreementTypeName))?></P>
			<!-- <P class="p3 ft1">(TRANSPORTATION AGREEMENT)</P> -->
			<P class="p4 ft1">Kontrak No. <?=$data->ContractNo?></P>
		</TD>
	</TR>
</table>

<TABLE cellpadding=0 cellspacing=0 class="t1">
<TR>
	<TD class="tr0 td2"><P class="p5 ft1">1. </P></TD>
	<TD class="tr0 td3"><P class="p6 ft1">Kepada (To)</P></TD>
	<TD colspan=2 class="tr0 td4">
		<P class="p7 ft1">: <?=$data->VendorName?></P>
	</TD>
	<TD class="tr0 td6"><P class="p1 ft1">2. Tanggal (Date)</P></TD>
	<TD class="tr0 td6"><P class="p1 ft1">: <?=date("d M Y", strtotime($data->Date))?></P></TD>
</TR>
<TR>
	<TD class="tr3 td2"><P class="p5 ft1">3. </P></TD>
	<TD class="tr3 td3"><P class="p6 ft1">Alamat Subkon</P></TD>
	<TD colspan=4 class="tr3 td9"><P class="p7 ft1">: <?=$data->Address1?></P></TD>
</TR>
<TR>
	<TD class="tr1 td2"><P class="p1 ft5">&nbsp;</P></TD>
	<TD class="tr1 td3"><P class="p6 ft2">(Subcontractor's Address)</P></TD>
	<TD colspan=4 class="tr1 td4"><P class="p10 ft2">Phone <?=$data->Telp?></P></TD>
</TR>
<TR>
	<TD class="tr4 td2"><P class="p5 ft1">4. </P></TD>
	<TD class="tr4 td3"><P class="p6 ft1">Nilai Kontrak</P></TD>
	<TD colspan=4 class="tr4 td4"><P class="p7 ft1">: Rp
		<?php
		$noNK = 0;
		$TotalNK = 0;

		//foreach ($AmountDescription as $val) {
		//	$TotalNK+=$val->Amount;
		//}
        
		//$PPNnk = round($TotalNK*0.1);
		//$TotalAllNK = round($TotalNK+$PPNnk);

		echo number_format($data->ContractAmount, 2,".",",")
		?></P>
	</TD>
</TR>
<TR>
	<TD class="tr0 td2"><P class="p1 ft6">&nbsp;</P></TD>
	<TD class="tr0 td3"><P class="p6 ft1">(Contract Amount)</P></TD>
	<TD colspan=4 class="tr0 td9"><P class="p12 ft1">Harga bersifat lumpsum fix price</P></TD>
</TR>
<TR>
	<TD class="tr5 td2"><P class="p1 ft6">&nbsp;</P></TD>
	<TD class="tr5 td3"><P class="p1 ft6">&nbsp;</P></TD>
	<TD colspan=4 class="tr5 td9">
		<P class="p10 ft1">
			<?=($data->WithPpn ? "Harga sudah termasuk PPN 10%" : "Harga tidak termasuk PPN 10%")?>
		</P>
	</TD>
</TR>
<TR>
	<TD class="tr2 td2"><P class="p1 ft6">&nbsp;</P></TD>
	<TD class="tr2 td3"><P class="p1 ft6">&nbsp;</P></TD>
	<TD colspan=4 class="tr2 td9"><P class="p10 ft1">Harga sudah termasuk PPH <?=$data->Pph?>%</P></TD>
</TR>
<TR>
	<TD class="tr6 td2"><P class="p5 ft1">5. </P></TD>
	<TD class="tr6 td3"><P class="p6 ft1">Waktu Pelaksanaan</P></TD>
	<TD colspan=4 class="tr6 td9"><P class="p7 ft1">: <?=$data->Date?></P></TD>
</TR>
<TR>
	<TD class="tr1 td2"><P class="p1 ft5">&nbsp;</P></TD>
	<TD class="tr1 td3"><P class="p6 ft2">Pekerjaan (Contract Period)</P></TD>
	<TD class="tr1 td7" colspan=4><P class="p1 ft5">&nbsp;</P></TD>
</TR>
<TR>
	<TD valign="top"><P class="p5 ft1">6. </P></TD>
	<TD valign="top"><P class="p6 ft1">Lingkup Pekerjaan <br>(Scope of Work)</P></TD>
	<TD class="tr3 td7" colspan=4><P class="p5 ft1"><?=$data->ScopeOfWork?></P></TD>
</TR>
<TR>
	<TD class="tr1 td7" colspan=6><P class="p1 ft5">&nbsp;</P></TD>
</TR>
<TR>
	<TD valign="top"><P class="p5 ft1">7. </P></TD>
	<TD valign="top"><P class="p6 ft1">Dasar Pelaksanaan Pekerjaan <br>(Basic of Work Execution)</P></TD>
	<TD valign="top" colspan=4><P class="p5 ft1"><?=$data->BasicOfWorkExecution?></P></TD>
</TR>
<TR>
	<TD class="tr1 td7" colspan=6><P class="p1 ft5">&nbsp;</P></TD>
</TR>
<TR>
	<TD valign="top"><P class="p5 ft1">8. </P></TD>
	<TD valign="top"><P class="p6 ft1">Cara Pembayaran</P></TD>
	<TD valign="top" colspan=4><P class="p5 ft1"><?=$data->PaymentTypeCode?></P></TD>
</TR>
<TR>
	<TD valign="top"><P class="p5 ft1"></P></TD>
	<TD valign="top"><P class="p6 ft1">(Payment Method)</P></TD>
	<TD valign="top" colspan=4><P class="p5 ft1"><?=$data->PaymentMethod?></P></TD>
</TR>
<TR>
	<TD class="tr1 td7" colspan=6><P class="p1 ft5">&nbsp;</P></TD>
</TR>
<TR>
	<TD valign="top"><P class="p5 ft1">9. </P></TD>
	<TD valign="top"><P class="p6 ft1">Pelaksanaan Pekerjaan</P></TD>
	<TD valign="top" colspan=4><P class="p5 ft1"><?=$data->ImplementPeriode?></P></TD>
</TR>
<TR>
	<TD class="tr1 td7" colspan=6><P class="p1 ft5">&nbsp;</P></TD>
</TR>
<TR>
	<TD valign="top"><P class="p5 ft1">10. </P></TD>
	<TD valign="top"><P class="p6 ft1">Asuransi & Jaminan</P></TD>
	<TD valign="top" colspan=4><P class="p5 ft1"><?=$data->ImplementInsurrance?></P></TD>
</TR>
<TR>
	<TD class="tr1 td7" colspan=6><P class="p1 ft5">&nbsp;</P></TD>
</TR>
<TR>
	<TD valign="top"><P class="p5 ft1">11. </P></TD>
	<TD valign="top" colspan=5><P class="p6 ft1">Uraian Nilai Pekerjaan<br>(Contract Value Description)</P></TD>
</TR>

<TR>
	<TD valign="top" colspan=6>
		<TABLE cellpadding=0 cellspacing=0 class="t2" id="table-desc">
			<TR>
				<TD align="center" width="10px"><P class="p22 ft2">No<br>(No)</P></TD>
				<TD align="center" width="80px"><P class="p19 ft1">8. Banyaknya<br>(Quantity)</P></TD>
				<TD align="center" width="25px"><P class="p19 ft1">Satuan</P></TD>
				<TD width="150px"><P class="p19 ft1">9. Deskripsi<br>(Description)</P></TD>
				<TD width="150px"><P class="p20 ft1">10. Spesifikasi Standard<br>(Specification & Standard)</P></TD>
				<TD align="center"><P class="p1 ft1">11. Harga Satuan<br>(Unit Price)</P></TD>
				<TD align="center"><P class="p21 ft1">12. Jumlah<br>(Amount)</P></TD>
			</TR>
			<?php
				$no=0;
				//$Total = 0;
				foreach ($AmountDescription as $val) {
					$no++;
			?>
					<TR>
						<TD align="center" valign="top"><?=$no?>.</TD>
						<TD align="center" valign="top"><?=$val->Qty?></TD>
						<TD align="center" valign="top"><?=$val->Unit?></TD>
						<TD valign="top"><?=$val->Description?></TD>
						<TD valign="top"><?=$val->Spesification?></TD>
						<TD align="right" valign="top">Rp. <?=number_format($val->UnitPrice)?></TD>
						<TD align="right" valign="top">Rp. <?=number_format($val->Amount)?></TD>
					</TR>
			<?php
			        $tempTot = str_replace(',', '', $val->Amount);
					$Total += (float)$tempTot;
				}
				$PPN = ( $data->WithPpn ? $Total * 0.1 : 0);
				$TotalAll = $Total+$PPN;
			?>
			<TR>
				<TD align="right" valign="top" colspan=5>TOTAL</TD>
				<TD align="right" valign="top" colspan=2>Rp. <?=number_format($Total)?></TD>
			</TR>
			<TR>
				<TD align="right" valign="top" colspan=5>PPN 10%</TD>
				<TD align="right" valign="top" colspan=2>Rp. <?=number_format($PPN)?></TD>
			</TR>
			<TR>
				<TD align="right" valign="top" colspan=5>Total Keseluruhan</TD>
				<TD align="right" valign="top" colspan=2>Rp. <?=number_format($data->ContractAmount, 0,".",",")?></TD>
			</TR>
		</TABLE>
	</TD>
</TR>

<TR>
	<TD valign="top" colspan=6><P class="p32 ft1">Terbilang: <?=terbilang($data->ContractAmount, $style=3)?> Rupiah</P></TD>
</TR>
<TR>
	<TD class="tr1 td7" colspan=6><P class="p1 ft5">&nbsp;</P></TD>
</TR>
<TR>
	<TD valign="top"><P class="p5 ft1">12. </P></TD>
	<TD valign="top"><P class="p6 ft1">Lain-Lain<br>(Miscellanous)</P></TD>
	<TD valign="top" colspan=4><P class="p5 ft1"><?=$data->ImplementInsurrance?></P></TD>
</TR>

</TABLE>

</DIV>

<DIV id="id_3">
<P class="p37 ft1">Demikian Perjanjian ini dibuat dan ditandatangani dengan dibubuhi meterai yang cukup di Jakarta pada tanggal, bulan dan tahun tersebut pada awal Perjanjian ini dalam rangkap 2 (dua)</P>
<TABLE cellpadding=0 cellspacing=0 class="t3" width="100%">
<TR>
	<TD align="center"><P class="p38 ft3">Yang Menerima Order</P></TD>
	<td width="80px"></td>
	<TD colspan=2 align="center"><P class="p39 ft3">Yang Memberi Order</P></TD>
</TR>
<TR>
	<TD align="center"><P class="p38 ft3"><?=$data->VendorName?></P></TD>
	<td></td>
	<TD colspan=2 align="center"><P class="p40 ft3">PT. PEMBANGUNAN PERUMAHAN (PERSERO)</P></TD>
</TR>
<TR>
	<TD align="center" colspan=4 height="80px"></TD>
</TR>
<TR>
	<TD align="center"><P class="p41 ft14"><?=$data->ReceivedAgreement?></P></TD>
	<td></td>
	<TD align="center"><P class="p42 ft15"><?=$data->Sender1Name?></P></TD>
	<TD align="center"><P class="p40 ft14"><?=$data->Sender2Name?></P></TD>
</TR>
<TR>
	<TD align="center"><P class="p41 ft11"><?=$data->ReceivedAgreementTitle?></P></TD>
	<td></td>
	<TD align="center"><P class="p43 ft3"><?=$data->Sender1Title?></P></TD>
	<TD align="center"><P class="p40 ft3"><?=$data->Sender2Title?></P></TD>
</TR>
</TABLE>

</DIV>
</DIV>
</div>
</BODY>
</HTML>
