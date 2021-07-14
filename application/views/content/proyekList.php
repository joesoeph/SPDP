<?php echo $this->session->userdata('message') <> '' ? "<div class='alert alert-success'>".$this->session->userdata('message')."</div>" : ""; ?>

<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li class="active"><i class="glyphicon glyphicon-list-alt"></i> Informasi Proyek</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row panel'>
      <div class='col-lg-12'>
    <?php //echo anchor(site_url('proyek/create/'),"<i class='glyphicon glyphicon-plus'></i> Tambah","class='btn btn-pocn'");?>
        <div class='clearfix'></div>
        <table class="table table-bordered table-striped" id="kotak">
            <thead>
                <tr>
                    <th width="10px">No</th>
            		    <th>Kode Proyek</th>
            		    <th>Nama Proyek</th>
            		    <th width="40%">Alamat</th>
                  </tr>
              </thead>

              <tbody>
              <?php
              $start = 0;
              foreach ($ArrData as $proyek)
              {
                  ?>
                  <tr>
            		    <td align="center"><?php echo ++$start ?></td>
            		    <td><?php echo $proyek->ProyekCode ?></td>
            		    <td><?php echo $proyek->ProyekName ?></td>
            		    <td><?php echo $proyek->ProyekDescription ?></td>
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
