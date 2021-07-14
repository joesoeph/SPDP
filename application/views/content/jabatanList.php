<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-hdd"></i> Data Master</a></li>
            <li class="active">Jabatan</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row panel'>
      <div class='col-lg-12'>
      <?php echo anchor(site_url('jabatan/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class='clearfix'></div>
        <table class="table table-bordered table-striped" id="kotak">
            <thead>
                <tr>
                    <th width="10px">No</th>
				    <th>Kode Jabatan</th>
				    <th>Nama Jabatan</th>
				    <th>Deskripsi</th>
				    <th></th>
                  </tr>
              </thead>
	
              <tbody>
              <?php
              $start = 0;
              foreach ($ArrData as $jabatan)
              {
                  ?>
                  <tr>
				    <td align="center"><?php echo ++$start ?></td>
				    <td><?php echo $jabatan->JabatanCode ?></td>
				    <td><?php echo $jabatan->JabatanName ?></td>
				    <td><?php echo $jabatan->Description ?></td>
				    <td style="text-align:center" width="140px">
					<?php 
					echo anchor(site_url('jabatan/read/'.$jabatan->JabatanId),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail')); 
					echo '  '; 
					echo anchor(site_url('jabatan/update/'.$jabatan->JabatanId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit')); 
					echo '  '; 
					echo anchor(site_url('jabatan/delete/'.$jabatan->JabatanId),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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