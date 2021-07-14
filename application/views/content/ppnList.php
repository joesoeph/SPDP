<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id="page-content-wrapper">
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-hdd"></i> Data Master</a></li>
            <li class="active">PPN Tagihan</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class="container-fluid">
    <div class='row panel'>
      <div class="col-lg-12">
        <?php echo anchor(site_url('PPN/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class="clearfix"></div>
        <table id="kotak" class="table table-bordered table-striped">
          <thead>
              <tr>
                  <th width="15px">No</th>
          		    <th>PPH</th>
          		    <th>Persen</th>
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
        		    <td><?= $val->PpnName ?></td>
                <td><?= $val->PpnValue ?></td>
        		    <td style="text-align:center" width="140px">
  			        <?php
            			echo anchor(site_url('PPN/read/'.$val->PpnId),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail'));
            			echo '  ';
            			echo anchor(site_url('PPN/update/'.$val->PpnId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit'));
            			echo '  ';
            			echo anchor(site_url('PPN/delete/'.$val->PpnId),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Anda yakin ?\')"');
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
