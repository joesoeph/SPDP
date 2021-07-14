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
    font-size: 12px;
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
<div>
	<table style="border-collapse: collapse; width: 100%;" border="1">
		<tbody>
			<tr>
				<td style="border: 0;">&nbsp;</td>
				<td style="width: 15%; text-align: center;">Form A-02</td>
			</tr>
		</tbody>
	</table>
	<table style="border-collapse: collapse; width: 100%; height: 57px; margin-bottom: 20px;" border="0">
		<tbody>
			<tr style="height: 19px;">
				<td style="width: 13.7354%; height: 19px;">
					<img src="<?= base_url('assets/logo.png') ?>" height="50px">
				</td>
				<td style="width: 47.5701%; height: 19px;"><strong>PT. Proxis Sahabat Indonesia</strong></td>
				<td style="width: 13.9366%; height: 19px; vertical-align: bottom;">BUKTI NO</td>
				<td style="width: 20.8236%; height: 19px; vertical-align: bottom;">: <?= $DataDetail->BudgetRequestNo ?></td>
			</tr>
			<tr style="height: 19px;">
				<td style="width: 61.3055%; height: 38px;" colspan="2" rowspan="2">&nbsp;</td>
				<td style="width: 13.9366%; height: 19px;">TANGGAL</td>
				<td style="width: 20.8236%; height: 19px;">: <?= $DataDetail->BudgetRequestDate ?></td>
			</tr>
			<tr style="height: 19px;">
				<td style="width: 13.9366%; height: 19px;">KLASIFIKASI</td>
				<td style="width: 20.8236%; height: 19px;">: <?= $DataDetail->Classification ?></td>
			</tr>
		</tbody>
	</table>
	<table style="border-collapse: collapse; width: 100%; height: 70px; margin-bottom: 10px;" border="1">
		<tbody>
			<tr style="height: 13px; border: 0;">
				<td style="width: 96.0656%; height: 13px;" colspan="5"><strong>FORM PERMOHONAN DANA HARIAN</strong><strong><br /></strong></td>
			</tr>
			<tr style="height: 19px;">
				<td style="width: 5.60866%; height: 19px; text-align: center;"><strong>No.</strong></td>
				<td style="width: 50.3249%; height: 19px;"><strong>Uraian</strong></td>
				<td style="width: 6.49856%; height: 19px; text-align: center;"><strong>Qty</strong></td>
				<td style="width: 15.7837%; height: 19px; text-align: right;"><strong>Harga</strong></td>
				<td style="width: 17.8498%; height: 19px; text-align: right;"><strong>Jumlah</strong></td>
			</tr>
			<?php $no = 1; ?>
			<?php foreach($DataRequests as $DataRequest) : ?>
			<tr style="height: 19px;">
				<td style="width: 5.60866%; height: 19px; text-align: center;"><?= $no++ ?></td>
				<td style="width: 50.3249%; height: 19px;"><?= $DataRequest->Spesification ?></td>
				<td style="width: 6.49856%; height: 19px; text-align: center;"><?= $DataRequest->Quantity ?></td>
				<td style="width: 15.7837%; height: 19px; text-align: right;"><?= number_format($DataRequest->Price, 2) ?></td>
				<td style="width: 17.8498%; height: 19px; text-align: right;"><?= number_format($DataRequest->Amount, 2) ?></td>
			</tr>
			<?php endforeach; ?>
			<tr style="height: 19px;">
				<td style="width: 78.2158%; text-align: right; height: 19px;" colspan="4"><strong>JUMLAH</strong></td>
				<td style="width: 17.8498%; height: 19px; text-align: right;"><?= number_format($DataDetail->TotalAmount, 2) ?></td>
			</tr>
		</tbody>
	</table>
	<table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;" border="1">
		<tbody>
		<tr>
			<td style="width: 10%; border-right: 0;"><strong>Terbilang:</strong></td>
			<td style="border-left: 0;"><em><?= terbilang($DataDetail->TotalAmount, 3) ?></em></td>
		</tr>
		</tbody>
	</table>
	<table style="border-collapse: collapse; width: 100%; height: 35px; text-align: center;" border="0">
		<tbody>
			<tr style="height: 16px;">
				<td style="width: 24.0164%; height: 16px;">Yang Mengajukan</td>
				<td style="width: 24.0164%; height: 16px;">
					<p>Mengetahui,</p>
					<p>General Manager</p>
				</td>
				<td style="width: 24.0164%; height: 16px;">Approval</td>
				<td style="width: 24.0164%; height: 16px;">Penerima Uang</td>
			</tr>
			<tr style="height: 19px;">
				<td style="width: 24.0164%; height: 19px;">
					<img src="<?= $DataDetail->CreatorTtd ?>" width="24%"> 
					<br> <?= $DataDetail->CreatorName ?>
				</td>
				<td style="width: 24.0164%; height: 19px;">
					<img src="<?= $DataDetail->Approval1Ttd ?>" width="24%">
					<br> <?= $DataDetail->Approval1Name ?>
				</td>
				<td style="width: 24.0164%; height: 19px;">
					<img src="<?= $DataDetail->Approval2Ttd ?>" width="24%">
					<br> <?= $DataDetail->Approval2Name ?>
				</td>
				<td style="width: 24.0164%; height: 19px;">
					<img src="<?= $DataDetail->RecipientTtd ?>" width="24%">
					<br> <?= $DataDetail->RecipientName ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
