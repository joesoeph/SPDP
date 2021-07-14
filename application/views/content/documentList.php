<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-hdd"></i> Data Master</a></li>
            <li class="active">Dokumen</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row panel'>
      <div class='col-lg-12'>
      <?php echo anchor(site_url('document/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class='clearfix'></div>
        <table class="table table-bordered table-striped" id="kotak">
            <thead>
                <tr>
                    <th width="10px" class="text-center">No</th>
				    <th>DocumentCode</th>
				    <th>DocumentName</th>
				    <th>Description</th>
				    <th>Action</th>
                </tr>
              </thead>
	
              <tbody>
              <?php
              $start = 0;
              foreach ($ArrData as $document)
              {
                  ?>
                  <tr>
				    <td align="center"><?php echo ++$start ?></td>
				    <td><?php echo $document->DocumentCode ?></td>
				    <td><?php echo $document->DocumentName ?></td>
				    <td><?php echo $document->Description ?></td>
				    <td style="text-align:center" width="140px">
					<?php 
					echo anchor(site_url('document/read/'.$document->DocumentId),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail')); 
					echo '  '; 
					echo anchor(site_url('document/update/'.$document->DocumentId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit')); 
					echo '  '; 
					echo anchor(site_url('document/delete/'.$document->DocumentId),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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