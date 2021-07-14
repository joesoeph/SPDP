<div class="navbar navbar-pocn-in" id="nav">
  <a href="#" class="navbar-brand">Tipe Proyek</a>
</div>

<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class='row'>
      <div class="col-lg-12">
        <?php echo anchor(site_url('ProyekType/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class="clearfix"></div>
        <table id="kotak" class="table table-bordered table-striped">
          <thead>
              <tr>
                  <th width="80px">No</th>
          		    <th>Kode Tipe Proyek</th>
          		    <th>Nama Tipe Proyek</th>
          		    <th></th>
              </tr>
          </thead>
  	    <tbody>
          <?php
          $start = 0;
          foreach ($ArrData as $val)
          {
              ?>
              <tr>
        		    <td><?= ++$start ?></td>
        		    <td><?= $val->ProyekTypeCode ?></td>
        		    <td><?= $val->ProyektypeName ?></td>
        		    <td style="text-align:center" width="140px">
  			        <?php
            			echo anchor(site_url('proyekType/read/'.$val->ProyekTypeId),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail'));
            			echo '  ';
            			echo anchor(site_url('proyekType/update/'.$val->ProyekTypeId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit'));
            			echo '  ';
            			echo anchor(site_url('proyekType/delete/'.$val->ProyekTypeId),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Anda yakin ?\')"');
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
