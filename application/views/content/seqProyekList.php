
<div class='navbar navbar-pocn-in' id='nav'>
  <a href='#' class='navbar-brand'>seqproyek</a>
</div>

<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
    <div class='row'>
      <div class='col-lg-12'>
		      <?php echo anchor(site_url('seqproyek/create/'),' <i class="glyphicon glyphicon-plus"></i> Add New','class="btn btn-pocn pull-right"');?>
        <div class='clearfix'></div>
        <table class="table table-bordered table-striped" id="kotak">
            <thead>
                <tr>
                    <th width="80px">No</th>
            		    <th>ProyekId</th>
            		    <th>VendorId</th>
            		    <th>Action</th>
                </tr>
              </thead>

              <tbody>
              <?php
              $start = 0;
              foreach ($ArrData as $seqproyek)
              {
                  ?>
                  <tr>
            		    <td><?php echo ++$start ?></td>
            		    <td><?php echo $seqproyek->ProyekId ?></td>
            		    <td><?php echo $seqproyek->VendorId ?></td>
            		    <td style="text-align:center" width="140px">
              			<?php
                			echo anchor(site_url('seqproyek/read/'.$seqproyek->ProyekSeqId),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail'));
                			echo '  ';
                			echo anchor(site_url('seqproyek/update/'.$seqproyek->ProyekSeqId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit'));
                			echo '  ';
                			echo anchor(site_url('seqproyek/delete/'.$seqproyek->ProyekSeqId),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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
