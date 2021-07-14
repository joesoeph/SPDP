<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-wrench"></i> Pengaturan</a></li>
            <li class="active">Pengguna</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row panel'>
      <div class='col-lg-12'>
        <?php echo anchor(site_url('users/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class='clearfix'></div>
        <table class="table table-bordered table-striped" id="kotak">
            <thead>
                <tr>
                    <th width="80px">No</th>
            		    <th>Nama</th>
            		    <th>Kode Jabatan</th>
            		    <th>Email</th>
            		    <th></th>
                  </tr>
              </thead>

              <tbody>
              <?php
              $start = 0;
              foreach ($ArrData as $users)
              {
                  ?>
                  <tr>
            		    <td><?php echo ++$start ?></td>
            		    <td><?php echo $users->name ?></td>
            		    <td><?php echo $users->JabatanCode ?></td>
            		    <td><?php echo $users->email ?></td>
            		    <td style="text-align:center" width="140px">
            			<?php
            			echo anchor(site_url('users/read/'.$users->id),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail'));
            			echo '  ';
            			echo anchor(site_url('users/update/'.$users->id),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit'));
            			echo '  ';
            			echo anchor(site_url('users/delete/'.$users->id),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Anda yakin ?\')"');
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
