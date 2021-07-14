
<div class='navbar navbar-pocn-in' id='nav'>
  <a href='#' class='navbar-brand'>Info Pembayaran</a>
</div>

<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
    <div class='row'>
      <div class='col-lg-12'>
		<?php 
		echo anchor(site_url('Payment/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class='clearfix'></div>
        <table class="table table-bordered table-striped" id="kotak">
            <thead>
                <tr>
                    <th width="10px">No</th>
				    <th>No. Invoice</th>
				    <th>Vendor</th>
				    <th>Tgl. Bayar</th>
				    <th>Pembuat</th>
				    <th></th>
                  </tr>
              </thead>
	
              <tbody>
              <?php
              $start = 0;
              foreach ($ArrData as $trnpayment)
              {
                  ?>
                  <tr>
				    <td align="center"><?php echo ++$start ?></td>
				    <td><?php echo $trnpayment->InvoiceNo ?></td>
				    <td><?php echo $trnpayment->VendorName ?></td>
				    <td><?php echo $trnpayment->PaymentDate ?></td>
				    <td><?php echo $this->getdetailusers->GetById($trnpayment->CreatedByUserId, 'name') ?></td>
				    <td style="text-align:center" width="140px">
					<?php 
					echo anchor(site_url('Payment/read/'.$trnpayment->PaymentId),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail')); 
					echo '  '; 
					echo anchor(site_url('Payment/update/'.$trnpayment->PaymentId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit')); 
					echo '  '; 
					echo anchor(site_url('Payment/delete/'.$trnpayment->PaymentId),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
					?>
		
                  </td>
	
                  </tr>
                  <?php
                }
              ?>
              </tbody>
          </table>
    </div>
  </div>
</div>
</div>