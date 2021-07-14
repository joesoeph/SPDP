<div class="navbar navbar-pocn-in" id="nav">
  <a href="#" class="navbar-brand">Verifikasi Invoice</a>
</div>

<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class='row'>
      <div class="col-lg-12">
        <?php echo anchor(site_url('VerifikasiInvoice/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class="clearfix"></div>
        <table id="kotak" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No.</th>
              <th>ID Invoice</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td>
              </tr>
          </tbody>
      </table>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
</div><!-- /.content -->
