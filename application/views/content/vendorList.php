<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
<!-- Main content -->
<div id="page-content-wrapper">
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-hdd"></i> Data Master</a></li>
            <li class="active">Vendor</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class="container-fluid">
    <div class='row panel'>
      <div class="col-lg-12">
        <?php echo anchor(site_url('Vendor/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class="clearfix"></div>
        <table id="kotak" class="table table-bordered table-striped">
          <thead>
              <tr>
                  <th width="80px">No</th>
          		    <th>Nama Vendor</th>
          		    <th>Alamat</th>
                  <th>Telpone</th>
          		    <th></th>
              </tr>
          </thead>
  	    <tbody>
          <?php
          $start = 0;
          foreach ($ArrData as $vendor)
          {
              ?>
              <tr>
        		    <td><?= ++$start ?></td>
        		    <td><?= $vendor->VendorName ?></td>
        		    <td><?= $vendor->Address1 ?></td>
                <td><?= $vendor->Telp ?></td>
        		    <td style="text-align:center" width="140px">
  			        <?php
            			echo anchor(site_url('vendor/read/'.$vendor->VendorId),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail'));
            			echo '  ';
            			echo anchor(site_url('vendor/update/'.$vendor->VendorId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit'));
            			echo '  ';
            			echo anchor(site_url('vendor/delete/'.$vendor->VendorId),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Ada yakin ?\')"');
  	            ?>
                </td>
              </tr>
              <?php
          }
          ?>
        </tbody>
      </table>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
</div><!-- /.content -->
