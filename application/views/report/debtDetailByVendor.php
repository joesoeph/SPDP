<style type="text/css">
	table {
		font: 'Calibri';
	}

	#tbl-list{
		border-collapse: collapse;
		border: 0.5px solid black;
	}
	#tbl-list td{
		border: 0.5px solid black;
		padding: 10px 10px 10px auto;
	}
	tr.noBorder td {
	  border: 0;
	}

</style>
<?php
foreach ($Vendor as $v) {
	$VendorName = $v->VendorName;
}
?>
<table width="100%">
	<tr>
		<td	align="center"><b>SALDO HUTANG</b></td>
	</tr>
	<tr>
		<td	align="center"><b>PER TANGGAL <?=date("Y-m-d")?></b></td>
	</tr>
	<tr>
		<td	align="center"><b>VENDOR : <?=$VendorName?></b></td>
	</tr>
	<tr>
		<td	align="center">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table border="1" width="100%" id="tbl-list">
				<tr>
					<th align="center" height="40px" width="25%">INVOICE</th>
					<th align="center" width="25%">TOTAL VALUE</th>
					<th align="center" width="20%">TGL BAYAR</th>
					<th align="center" width="20%">INVOICE</th>
					<th align="center" width="25%">NILAI BAYAR</th>
				</tr>
				<tr>
					<td align="center" valign="top">
						<?php 
						$CountInvoice = 0;
						foreach ($DataInvoice as $val) {
							echo $val->InvoiceNo."<br><br>";
        					$CountInvoice++;
						}
						?>
					</td>
					<td align="right" valign="top">
						<?php 
						$TotalAmount = 0;
						foreach ($DataInvoice as $val) {
							echo number_format($val->TotalValue)."<br><br>";
							$TotalAmount+=$val->TotalValue;
						}
						?>
					</td>
					<td align="right" valign="top">
						<?php 
						foreach ($DataPembayaran as $val) {
							echo $val->PaymentDate."<br><br>";
						}
						?>
					</td>
					<td align="right" valign="top">
						<?php 
						foreach ($DataPembayaran as $val) {
							echo $val->InvoiceNo."<br><br>";
						}
						?>
					</td>
					<td align="right" valign="top">
						<?php 
						$TotalPayment = 0;
						foreach ($DataPembayaran as $val) {
							echo number_format($val->PaymentValue)."<br><br>";
							$TotalPayment+=$val->PaymentValue;
						}
						?>
					</td>
				</tr>
				<tr>
					<td height="40px" style="padding-left: 10px">TOTAL TAHGIHAN</td>
					<td align="right" align="right"><?=number_format($TotalAmount)?></td>
					<td colspan="2" style="padding-left: 10px">TOTAL PEMBAYARAN</td>
					<td align="right" align="right"><?=number_format($TotalPayment)?></td>
				</tr>
				<tr class="noBorder">
					<td height="40px" colspan="2" style="padding-left: 10px">JMLAH INVOICE</td>
					<td align="center" align="right">:</td>
					<td align="center" align="right" colspan="2"><?=$CountInvoice?></td>
				</tr>
				<tr class="noBorder">
					<td height="40px" colspan="2" style="padding-left: 10px">SALDO HUTANG</td>
					<td align="center" align="right">:</td>
					<td align="center" align="right" colspan="2"><?=number_format($TotalAmount-$TotalPayment)?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>